<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Venue;
use App\Models\Shg;
use App\Models\ShgMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;
use Maestroerror\HeicToJpg;
use Illuminate\Support\Facades\DB;

class CadreController extends Controller
{

    public function viewShgMembers(Request $request)
    {
        $user = auth()->user();
        $memCode = auth()->user()->name;

        // Cadre details
        $cadre = ShgMember::select('mem_name')
            ->where('mem_code', $memCode)
            ->first();

        // Venue assigned to cadre
        $venue = Venue::select('id', 'venue_name')
            ->where('monitored_by', $memCode)
            ->firstOrFail();


        // SHGs mapped to venue
        $shgs = DB::table('shg as s')
            ->leftJoin('member as m', function ($join) {
                $join->on('m.shg_code', '=', 's.shg_code')
                    ->where('m.mem_status', 1);
            })
            ->where('s.venue_id', $venue->id)
            ->where('s.shg_status', 1)
            ->groupBy(
                's.shg_id',
                's.shg_code',
                's.shg_name',
                's.venue_id'
            )
            ->orderBy('s.shg_name')
            ->select(
                's.shg_id',
                's.shg_code',
                's.shg_name',
                's.venue_id',
                DB::raw('COUNT(m.mem_no) AS members_count'),
                DB::raw('SUM(CASE WHEN m.yoga2026_registration = 1 THEN 1 ELSE 0 END) AS registered_count')
            )
            ->get();

        return view('cadre.allyogaregister', [
            'venue' => $venue,
            'shgs' => $shgs,
            'memberName' => $cadre?->mem_name ?? 'N/A',
        ]);

    }
    public function addattendance($shg_code)
    {
        $memCode = auth()->user()->name;

        $memberName = ShgMember::where('mem_code', $memCode)
            ->value('mem_name');

        $venue = Venue::where('monitored_by', $memCode)
            ->first();

        // Members of selected SHG
        $members = DB::table('member')
            ->join('shg', 'shg.shg_code', '=', 'member.shg_code')
            ->where('shg.venue_id', $venue->id)
            ->where('member.mem_status', 1)
            ->where('member.shg_code', $shg_code)
            ->select(
                'member.*',
                'shg.shg_name'
            )
            ->orderBy('shg.shg_name')
            ->orderBy('member.mem_name')
            ->get();



        return view('cadre.addattendance', compact(
            'members',
            'memberName',
            'venue'
        ));
    }
    public function storeAttendance(Request $request)
    {
        $request->validate([
            'member_codes' => 'required|array',
        ]);

        // Mark all members as absent
        ShgMember::whereIn('mem_code', $request->member_codes)
            ->update([
                'yoga_attendance' => 0
            ]);

        // Mark selected members as present
        if ($request->filled('attendance')) {

            ShgMember::whereIn('mem_code', $request->attendance)
                ->update([
                    'yoga_attendance' => 1
                ]);
        }

        return back()->with(
            'success',
            'Attendance Submitted Successfully.'
        );
    }
    public function showUploadVenuePhoto()
    {
        $memCode = Auth::user()->name;
        $memberName = ShgMember::where('mem_code', $memCode)->value('mem_name');
        $venue = Venue::where('monitored_by', $memCode)->first();


        return view('cadre.UploadVenuephoto', compact('venue', 'memberName'));
    }
    public function storeVenuePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|mimes:jpg,jpeg,png,heic,heif|max:10240',
        ]);



        $memCode = Auth::user()->name;


        $venue = Venue::where('monitored_by', $memCode)->firstOrFail();
        $userId = Auth::id();

        $photo = $request->file('photo');
        $photoName = time() . '_venue_' . $venue->id . '.jpg';

        $query = DB::table('venue')
            ->join('village', 'village.vill_id', '=', 'venue.village_id')
            ->join('gp', 'gp.gp_id', '=', 'village.gp_id')
            ->join('block', 'block.block_id', '=', 'gp.block_id')
            ->where('venue.monitored_by', $memCode)
            ->select(
                'block.district_id',
                'block.block_id',
                'gp.gp_id',
                'village.vill_id',
                'venue.id',
            )->first();
        $filename = implode('/', (array) $query);



        $tempDir = storage_path('app/temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }
        $tempPath = $tempDir . DIRECTORY_SEPARATOR . $photoName;

        try {
            $manager = new ImageManager(new Driver());

            $ext = strtolower($photo->getClientOriginalExtension());
            $isHeic = \in_array($ext, ['heic', 'heif'])
                || HeicToJpg::isHeic($photo->getRealPath());

            if ($isHeic) {
                try {
                    $jpgBytes = HeicToJpg::convert($photo->getRealPath())->get();
                    $image = $manager->read($jpgBytes);
                } catch (\Throwable $heicErr) {
                    @unlink($tempPath);
                    return back()->with(
                        'error',
                        'HEIC/HEIF conversion is not supported on this server. ' .
                        'Please convert your photo to JPG before uploading.'
                    );
                }
            } else {
                $image = $manager->read($photo->getRealPath());
            }

            $image->scale(width: 1200);

            $quality = 85;
            $maxBytes = 500 * 1024;
            do {
                $encoded = $image->encode(new JpegEncoder(quality: $quality));
                $quality -= 5;
            } while (strlen((string) $encoded) > $maxBytes && $quality >= 20);

            file_put_contents($tempPath, (string) $encoded);

            $s3Key = 'Venue/' . $filename . '/' . $photoName;

            Storage::disk('s3')->put($s3Key, file_get_contents($tempPath));

            @unlink($tempPath);

            $venue->update(['photo' => $s3Key]);

            return back()->with('success', 'Venue photo uploaded successfully.');
        } catch (\Throwable $e) {
            @unlink($tempPath);
            return back()->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }
    public function viewShgs()
    {
        $memCode = auth()->user()->name;

        // Cadre details
        $cadre = ShgMember::select('mem_name')
            ->where('mem_code', $memCode)
            ->first();

        // Venue assigned to cadre
        $venue = Venue::select('id', 'venue_name')
            ->where('monitored_by', $memCode)
            ->firstOrFail();

        // SHGs mapped to venue
        $shgs = DB::table('shg as s')
            ->leftJoin('member as m', function ($join) {
                $join->on('m.shg_code', '=', 's.shg_code')
                    ->where('m.mem_status', 1);
            })
            ->where('s.venue_id', $venue->id)
            ->where('s.shg_status', 1)
            ->groupBy(
                's.shg_id',
                's.shg_code',
                's.shg_name',
                's.venue_id'
            )
            ->orderBy('s.shg_name')
            ->select(
                's.shg_id',
                's.shg_code',
                's.shg_name',
                's.venue_id',
                DB::raw('COUNT(m.mem_no) AS members_count'),
                DB::raw('SUM(CASE WHEN m.yoga2026_registration = 1 THEN 1 ELSE 0 END) AS registered_count'),
                DB::raw('SUM(CASE WHEN m.yoga_attendance = 1 THEN 1 ELSE 0 END) AS attendance')
            )
            ->get();

        return view('cadre.attendance', [
            'venue' => $venue,
            'shgs' => $shgs,
            'memberName' => $cadre?->mem_name ?? 'N/A',
        ]);
    }
    public function deletephoto(Request $request)
    {
        $memCode = Auth::user()->name;
        $venue = Venue::where('monitored_by', $memCode)->first();

        if (!$venue || !$venue->photo) {
            return back()->with('error', 'No photo found to delete.');
        }

        // Delete from S3
        if (Storage::disk('s3')->exists($venue->photo)) {
            Storage::disk('s3')->delete($venue->photo);
        }

        // Clear the photo column in DB
        $venue->photo = null;
        $venue->save();

        return back()->with('success', 'Photo deleted successfully.');
    }
    public function registeredmemberdetails($shg_code)
    {
        $userdata = auth()->user();

        $shg = Shg::where('shg_code', $shg_code)
            ->first();

        if (!$shg) {
            return back()->with('error', 'SHG not found.');
        }

        $members = ShgMember::where('shg_code', $shg_code)
            ->where('yoga2026_registration', 1)
            ->orderBy('mem_name')
            ->get();
        return view('cadre.shgregistereddetails', compact('shg', 'members', 'userdata'));
    }
}
