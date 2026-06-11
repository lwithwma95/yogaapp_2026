<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Shg;
use Illuminate\Support\Facades\Http;
use App\Models\District;
use App\Models\Block;
use App\Models\Gp;
use App\Models\Village;
use App\Models\ShgMember;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;
use Maestroerror\HeicToJpg;

class YogaRegistrationController extends Controller
{
    private function verifyTurnstile(Request $request): bool
    {
        $token = $request->input('cf-turnstile-response', '');
        if (!$token)
            return false;
        $resp = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => config('services.turnstile.secret'),
            'response' => $token,
            'remoteip' => $request->ip(),
        ]);
        return $resp->json('success', false);
    }

    public function findmembers(Request $request)
    {
        // DISTRICTS

        $districts = District::orderBy('district_name')->get();

        // SELECTED ITEMS

        $selectedDistrict = null;
        $selectedBlock = null;
        $selectedGp = null;
        $selectedVillage = null;

        if ($request->filled('district_id')) {

            $selectedDistrict = District::where(
                'district_id',
                $request->district_id
            )->first();
        }

        if ($request->filled('block_id')) {

            $selectedBlock = Block::where(
                'block_id',
                $request->block_id
            )->first();
        }

        if ($request->filled('gp_id')) {

            $selectedGp = Gp::where(
                'gp_id',
                $request->gp_id
            )->first();
        }

        if ($request->filled('vill_id')) {

            $selectedVillage = Village::where(
                'vill_id',
                $request->vill_id
            )->first();
        }

        // MEMBERS

        $shgmembers = ShgMember::whereRaw('1=0')->paginate(25);

        if ($request->filled('shg_code'))
            $shgmembers = ShgMember::select(
                'mem_no',
                'mem_uid',
                'shg_code',
                'mem_code',
                'mem_name',
                'mem_guard_name',
                'mem_mobile',
                'yoga_selfie',
                'yoga2026_registration'
            )
                ->with([
                    'shg:shg_code,shg_name,vill_id_new',
                    'shg.village:vill_id,vill_name,gp_id',
                    'shg.village.gp:gp_id,gp_name,block_id',
                    'shg.village.gp.block:block_id,block_name,district_id',
                    'shg.village.gp.block.district:district_id,district_name'
                ])
                ->where('shg_code', $request->shg_code)
                ->paginate(25);

        return view('yogaday2026.findmembers', compact(
            'districts',
            'selectedDistrict',
            'selectedBlock',
            'selectedGp',
            'selectedVillage',
            'shgmembers'
        ));
    }
    public function viewMember($mem_uid)
    {
        $member = ShgMember::with([
            'shg.village.gp.block.district'
        ])->where('mem_uid', $mem_uid)->firstOrFail();

        return view('yogaday2026.registration', compact('member'));
    }
    public function store(Request $request)
    {

        $request->validate([
            'mem_no' => 'required|exists:member,mem_no',
            'mobile' => 'required|digits:10',
            'photo' => 'required|mimes:jpg,jpeg,png,heic,heif|max:10240',
        ]);

        // FIND MEMBER WITH FULL LOCATION CHAIN

        $member = ShgMember::with([
            'shg.village.gp.block.district',
        ])->where('mem_no', $request->mem_no)->firstOrFail();

        // RESOLVE LOCATION CHAIN ONCE — used for S3 path and analytics increments
        $districtId = optional(optional(optional(optional($member->shg)->village)->gp)->block)->district_id ?? 'unknown';
        $blockId = optional(optional(optional($member->shg)->village)->gp)->block_id ?? 'unknown';
        $gpId = optional(optional($member->shg)->village)->gp_id ?? 'unknown';
        $villId = optional($member->shg)->vill_id_new ?? 'unknown';
        $shgCode = $member->shg_code;



        $photoName = null;

        if ($request->hasFile('photo')) {

            $photo = $request->file('photo');

            $photoName =
                time() . '_' .
                $member->mem_no . '.jpg';

            // TEMP DIRECTORY

            $tempDir = storage_path('app/temp');

            if (!is_dir($tempDir)) {

                mkdir($tempDir, 0755, true);

            }

            $tempPath =
                $tempDir . DIRECTORY_SEPARATOR . $photoName;

            try {

                $manager = new ImageManager(new Driver());

                // HEIC → convert to JPG bytes first using Go binary, then read with GD
                if (HeicToJpg::isHeic($photo->getRealPath())) {
                    $jpgBytes = HeicToJpg::convert($photo->getRealPath())->get();
                    $image = $manager->read($jpgBytes);
                } else {
                    // JPG / PNG — read directly with GD
                    $image = $manager->read($photo->getRealPath());
                }

                // RESIZE IMAGE (only scale down, never up)

                $image->scaleDown(
                    width: 1200
                );

                // COMPRESS LOOP

                $quality = 85;

                $maxBytes = 500 * 1024;

                do {

                    $encoded = $image->encode(
                        new JpegEncoder(
                            quality: $quality
                        )
                    );

                    $quality -= 5;

                } while (

                    \strlen((string) $encoded) > $maxBytes
                    && $quality >= 20

                );

                // SAVE TEMP FILE

                file_put_contents(
                    $tempPath,
                    (string) $encoded
                );

                // S3 PATH — hierarchical by location

                $s3Key = "yoga_selfies/{$districtId}/{$blockId}/{$gpId}/{$villId}/{$shgCode}/{$photoName}";

                // UPLOAD TO S3

                $uploaded = Storage::disk('s3')->put(

                    $s3Key,

                    file_get_contents($tempPath)

                );


                // DELETE TEMP FILE

                @unlink($tempPath);

                if (!$uploaded) {

                    return back()
                        ->withErrors([

                            'photo' =>
                                'Photo upload failed.'

                        ])
                        ->withInput();

                }

            } catch (\Exception $e) {

                $prev = $e->getPrevious();
                Log::error('Upload Error', [
                    'message' => $e->getMessage(),
                    'cause' => $prev ? $prev->getMessage() : 'none',
                    'class' => \get_class($e),
                ]);

                return back()
                    ->withErrors([

                        'photo' =>
                            $e->getMessage()

                    ])
                    ->withInput();

            }

        }
        // UPDATE MEMBER

        ShgMember::where(
            'mem_no',
            $request->mem_no
        )->update([
                    'mem_mobile' => $request->mobile,
                    'yoga_selfie' => $s3Key,
                    'yoga2026_registration' => 1,
                    'yoga_reg_date' => now(),
                    'yoga_token' => '2026-YOGA-' . $member->mem_code . '-' . strtoupper(Str::random(7)),
                ]);

        if ($member->wasChanged('yoga2026_registration') || $member->yoga2026_registration != 1) {

            if ($blockId) {
                DB::table('block_analytics')
                    ->where('block_id', $blockId)
                    ->increment('registered', 1, [
                        'updated_at' => now()
                    ]);

            }

            if ($districtId) {
                DB::table('analytics')->updateOrInsert(
                    ['district_code' => $districtId],
                    [
                        'count' => DB::raw('COALESCE(count,0) + 1'),
                        'updated_at' => now()
                    ]
                );
            }
        }

        return redirect()->route(

            'yoga.registration.view',

            [

                'mem_uid' => $member->mem_uid

            ]

        )->with(

                'success',

                'Yoga Registration Completed Successfully'

            );
    }
    public function showRegistration($mem_uid)
    {
        $member = ShgMember::with([
            'shg.village.gp.block.district'
        ])->where('mem_uid', $mem_uid)->firstOrFail();

        return view('yogaday2026.viewregistration', compact('member'));
    }
    public function searchbyshg()
    {
        return view('yogaday2026.searchbyshg');
    }
    public function confirmRegister(Request $request)
    {
        $request->validate(['mem_uid' => 'required|string']);
        return redirect()->route('yoga.registration', $request->mem_uid);
    }

    public function findMembersResult(Request $request)
    {
        $request->validate([
            'shg_code' => 'required'
        ]);

        $members = ShgMember::where(
            'shg_code',
            $request->shg_code
        )
            ->where('mem_status', 1)
            ->orderBy('mem_name')
            ->get();

        return view(
            'yogaday2026.searchbyshg',
            [
                'members' => $members,
                'shg_code' => $request->shg_code
            ]
        );
    }
}