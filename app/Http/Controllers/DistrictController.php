<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DistrictController extends Controller
{
    public function dashboard()
    {
        $userdata = auth()->user();
        $districtId = $userdata->district;

        $district = DB::table('district')->where('district_id', $districtId)->first();


        return view('district.dashboard', compact(
            'userdata',
            'district'
        ));
    }

    public function registration()
    {
        $userdata = auth()->user();

        $blocks = DB::table('block')
            ->leftJoin('gp', 'gp.block_id', '=', 'block.block_id')
            ->leftJoin('village', 'village.gp_id', '=', 'gp.gp_id')
            ->leftJoin('shg', function ($join) {
                $join->on('shg.vill_id_new', '=', 'village.vill_id')
                    ->where('shg.shg_status', 1);
            })
            ->leftJoin('member', function ($join) {
                $join->on('member.shg_code', '=', 'shg.shg_code')
                    ->where('member.mem_status', 1);
            })
            ->where('block.district_id', $userdata->district)
            ->selectRaw("
            block.block_id,
            block.block_name,
            COUNT(member.mem_no) AS total,
            COALESCE(SUM(member.yoga2026_registration = 1), 0) AS registered,
            COALESCE(SUM(member.yoga_attendance = 1), 0) AS attendance
            ")
            ->groupBy('block.block_id', 'block.block_name')
            ->orderBy('block.block_name')
            ->get();
        $total = $blocks->sum('total');
        $registered = $blocks->sum('registered');
        $totalAttendance = $blocks->sum('attendance');
        $active_page = 'registrations';
        return view('district.registration', compact(
            'userdata',
            'blocks',
            'total',
            'registered',
            'totalAttendance',
            'active_page',
        ));
    }

    public function cadreVenueMapping()
    {
        $userdata = auth()->user();
        $districtId = $userdata->district;

        $district = DB::table('district')
            ->where('district_id', $districtId)
            ->first();

        $rows = DB::table('block as b')
            ->leftJoin('gp as g', 'g.block_id', '=', 'b.block_id')
            ->leftJoin('village as vg', 'vg.gp_id', '=', 'g.gp_id')
            ->leftJoin('venue as v', 'v.village_id', '=', 'vg.vill_id')
            ->leftJoin('shg as s', 's.venue_id', '=', 'v.id')
            ->where('b.district_id', $districtId)
            ->groupBy('b.block_id', 'b.block_name')
            ->select(
                'b.block_id',
                'b.block_name',
                DB::raw('COUNT(DISTINCT v.id) as total_venues'),
                DB::raw('COUNT(DISTINCT s.shg_id) as total_shg'),
                DB::raw("COUNT(DISTINCT CASE WHEN v.photo IS NOT NULL AND v.photo <> '' THEN v.id END) as photo_uploaded"),
                DB::raw("COUNT(DISTINCT CASE WHEN v.photo IS NULL OR v.photo = '' THEN v.id END) as notUp")
            )
            ->orderBy('b.block_name')
            ->get();

        return view(
            'district.cadrevenuemapping',
            compact('userdata', 'district', 'rows')
        );
    }
    public function cadreVenueMappingBlock($block_id)
    {
        $userdata = auth()->user();

        $query = DB::table('gp')
            ->leftJoin('village', 'village.gp_id', '=', 'gp.gp_id')
            ->leftJoin('venue', 'venue.village_id', '=', 'village.vill_id')
            ->leftJoin('shg', 'shg.venue_id', '=', 'venue.id')
            ->where('gp.block_id', $block_id)
            ->selectRaw("
                gp.gp_id,
                gp.gp_name,
                COUNT(DISTINCT venue.id) AS total_venues,
                COUNT(DISTINCT CASE
                    WHEN venue.photo IS NOT NULL
                    AND venue.photo <> ''
                    THEN venue.id
                END) AS photo_uploaded,
                COUNT(DISTINCT CASE
                    WHEN venue.photo IS NULL
                    OR venue.photo = ''
                    THEN venue.id
                END) AS photo_pending,
                COUNT(DISTINCT shg.shg_id) AS total_shg
            ")
            ->groupBy('gp.gp_id', 'gp.gp_name')
            ->orderBy('gp.gp_name');

        //dd($query->toSql(), $query->getBindings());
        $rows = $query->get();
        return view('district.cvm_gp', compact(
            'userdata',
            'rows'
        ));
    }

    public function cadreVenueMappingGp($gp_id)
    {
        $userdata = auth()->user();

        $rows = DB::table('village')
            ->leftJoin('venue', 'venue.village_id', '=', 'village.vill_id')
            ->leftJoin('shg', 'shg.venue_id', '=', 'venue.id')
            ->where('village.gp_id', $gp_id)
            ->selectRaw("
                village.vill_id,
                village.vill_name,
                COUNT(DISTINCT venue.id) AS total_venues,
                COUNT(DISTINCT CASE WHEN venue.photo IS NOT NULL AND venue.photo != '' THEN venue.id END) AS photo_uploaded,
                COUNT(DISTINCT shg.shg_id) AS total_shg
            ")
            ->groupBy('village.vill_id', 'village.vill_name')
            ->orderBy('village.vill_name')
            ->get();

        return view('district.cvm_village', compact(
            'userdata',
            'rows'
        ));
    }
    public function cadreVenueMappingVillage($village_id)
    {
        $userdata = auth()->user();


        $village = DB::table('village')
            ->join('gp', 'gp.gp_id', '=', 'village.gp_id')
            ->join('block', 'block.block_id', '=', 'gp.block_id')
            ->where('village.vill_id', $village_id)
            ->select(
                'village.vill_id',
                'village.vill_name',
                'gp.gp_name',
                'block.block_name',
                'block.district_id'
            )
            ->first();

        $venues = DB::table('venue')
            ->leftJoin('member', 'member.mem_code', '=', 'venue.monitored_by')
            ->leftJoin('shg', 'shg.venue_id', '=', 'venue.id')
            ->where('venue.village_id', $village_id)
            ->select(
                'venue.id as venue_id',
                'venue.venue_name',
                'venue.photo',
                'venue.capacity',
                'venue.monitored_by',
                'member.mem_name',
                'member.mem_code as cadre_code',
                DB::raw('COUNT(DISTINCT shg.shg_id) as total_shg')
            )
            ->groupBy(
                'venue.id',
                'venue.venue_name',
                'venue.photo',
                'venue.capacity',
                'venue.monitored_by',
                'member.mem_name',
                'member.mem_code'
            )
            ->orderBy('venue.venue_name')
            ->get();

        return view('district.cvm_venues', compact(
            'userdata',
            'village',
            'venues'
        ));
    }
    public function mappedshg($venue_id)
    {
        $userdata = auth()->user();

        $venue = DB::table('venue')
            ->leftJoin('member as cadre', 'cadre.mem_code', '=', 'venue.monitored_by')
            ->where('venue.id', $venue_id)
            ->select(
                'venue.venue_name',
                'venue.capacity',
                'cadre.mem_name as cadre_name',
                'cadre.mem_code as cadre_code'
            )
            ->first();

        $shgs = DB::table('shg')
            ->leftJoin('member', 'member.shg_code', '=', 'shg.shg_code')
            ->where('shg.venue_id', $venue_id)
            ->select(
                'shg.shg_code',
                'shg.shg_name',
                DB::raw('COUNT(member.mem_no) as total_members'),
                DB::raw('SUM(CASE WHEN member.yoga2026_registration = 1 THEN 1 ELSE 0 END) as total_registered')
            )
            ->groupBy('shg.shg_code', 'shg.shg_name')
            ->orderBy('shg.shg_name')
            ->get();


        return view('district.mapped_shg', compact(
            'userdata',
            'shgs',
            'venue'
        ));
    }



    public function blockDetails($block_id)
    {
        $userdata = auth()->user();
        $gpRows = DB::table('gp')
            ->leftJoin('village', 'village.gp_id', '=', 'gp.gp_id')
            ->leftJoin('shg', function ($join) {
                $join->on('shg.vill_id_new', '=', 'village.vill_id')
                    ->where('shg.shg_status', 1);
            })
            ->leftJoin('member', function ($join) {
                $join->on('member.shg_code', '=', 'shg.shg_code')
                    ->where('member.mem_status', 1);
            })
            ->where('gp.block_id', $block_id)
            ->selectRaw("
            gp.gp_id,
            gp.gp_name,
            COUNT(member.mem_no) AS total,
            COALESCE(SUM(member.yoga2026_registration = 1), 0) AS registered,
            COALESCE(SUM(member.yoga_attendance = 1), 0) AS attendance
        ")
            ->groupBy('gp.gp_id', 'gp.gp_name')
            ->orderBy('gp.gp_name')
            ->get();

        $total = $gpRows->sum('total');
        $registered = $gpRows->sum('registered');

        $totalAttendance = $gpRows->sum('attendance');
        $active_page = 'registrations';
        return view('district.blockdetails', compact(
            'userdata',
            'gpRows',
            'total',
            'registered',
            'totalAttendance',
            'active_page'
        ));
    }
    public function gpDetails($gp_id)
    {
        $userdata = auth()->user();

        $villageRows = DB::table('village')
            ->leftJoin('shg', function ($join) {
                $join->on('shg.vill_id_new', '=', 'village.vill_id')
                    ->where('shg.shg_status', 1);
            })
            ->leftJoin('member', function ($join) {
                $join->on('member.shg_code', '=', 'shg.shg_code')
                    ->where('member.mem_status', 1);
            })
            ->where('village.gp_id', $gp_id)
            ->selectRaw("
                village.vill_id,
                village.vill_name,
                COUNT(member.mem_no) AS total,
                SUM(member.yoga2026_registration = 1) AS registered,
                SUM(member.yoga_attendance = 1) AS attendance
            ")
            ->groupBy('village.vill_id', 'village.vill_name')
            ->orderBy('village.vill_name')
            ->get();
        //print_r($villageRows);

        $total = $villageRows->sum('total');
        $registered = $villageRows->sum('registered');
        $totalAttendance = $villageRows->sum('attendance');
        $active_page = 'registrations';
        return view('district.gpdetails', compact(
            'userdata',
            'villageRows',
            'total',
            'registered',
            'totalAttendance',
            'active_page'
        ));
    }

    public function villageDetails($village_id)
    {
        $userdata = auth()->user();

        $shgRows = DB::table('shg')
            ->leftJoin('member', function ($join) {
                $join->on('member.shg_code', '=', 'shg.shg_code')
                    ->where('member.mem_status', 1);
            })
            ->where('shg.shg_status', 1)
            ->where('shg.vill_id_new', $village_id)
            ->select(
                'shg.shg_code',
                'shg.shg_name',
                DB::raw('COUNT(member.mem_no) as total'),
                DB::raw('SUM(member.yoga2026_registration = 1) as registered'),
                DB::raw('SUM(member.yoga_attendance = 1) as attendance')
            )
            ->groupBy('shg.shg_code', 'shg.shg_name')
            ->orderBy('shg.shg_name')
            ->get();

        $total = $shgRows->sum('total');
        $registered = $shgRows->sum('registered');

        $totalAttendance = $shgRows->sum('attendance');
        $active_page = 'registrations';
        return view('district.villagedetails', compact(
            'userdata',
            'shgRows',
            'total',
            'registered',
            'totalAttendance',
            'active_page',
        ));
    }

    public function shgRegisteredMembers($shg_code)
    {
        $userdata = auth()->user();

        $members = DB::table('shg')
            ->join('member', 'shg.shg_code', '=', 'member.shg_code')
            ->where('shg.shg_code', $shg_code)
           
            ->orderBy('member.mem_name')
            ->select(
                'shg.shg_name',
                'shg.shg_code',
                'member.mem_no',
                'member.mem_name',
                'member.mem_code',
                'member.mem_mobile',
                'member.yoga_selfie',
                'member.yoga_reg_date',
                'member.yoga_attendance',
                'member.yoga2026_registration'
            )
            ->get();

        /** @var \Illuminate\Filesystem\FilesystemAdapter $s3 */
        $s3 = Storage::disk('s3');
        $expiresAt = now()->addHours(1);

        $photoUrls = [];
        foreach ($members as $member) {
            if ($member->yoga_selfie) {
                try {
                    $photoUrls[$member->mem_no] = $s3->temporaryUrl(
                        "{$member->yoga_selfie}",
                        $expiresAt
                    );
                } catch (\Exception $e) {
                    $photoUrls[$member->mem_no] = null;
                }
            }
        }
        $active_page = 'registrations';
        return view('district.shgregisteredmembers', compact('userdata', 'members', 'photoUrls', 'active_page'));
    }
}
