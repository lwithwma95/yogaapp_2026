<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Block;
use App\Models\Gp;
use App\Models\Village;
use App\Models\Shg;
use App\Models\ShgMember;
use App\Models\Analytics;
use App\Models\BlockAnalytics;
use App\Models\Venue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StateController extends Controller
{
    public function dashboard()
    {
        $userdata = auth()->user();

        return view('state.dashboard', compact(
            'userdata'
        ));
    }
    public function allregistration()
    {
        $start = microtime(true);
        $userdata = auth()->user();
        set_time_limit(300);
        ini_set('max_execution_time', 300);
        
        $report = DB::table('district')

            ->join('block', 'block.district_id', '=', 'district.district_id')
            ->join('gp', 'gp.block_id', '=', 'block.block_id')
            ->join('village', 'village.gp_id', '=', 'gp.gp_id')
            ->join('shg', function ($join) {
                $join->on('shg.vill_id_new', '=', 'village.vill_id')
                    ->where('shg.shg_status', 1);
            })
            ->join('member', 'member.shg_code', '=', 'shg.shg_code')

            ->selectRaw('
                district.district_id as id,
                district.district_name as name,
                SUM(CASE WHEN member.mem_status = 1 THEN 1 ELSE 0 END) as total_member,
                SUM(CASE WHEN member.mem_status = 1 AND member.yoga2026_registration = 1 THEN 1 ELSE 0 END) as total_reg,
                SUM(CASE WHEN member.mem_status = 1 AND member.yoga2026_registration = 1 and member.yoga_attendance=1 THEN 1 ELSE 0 END) as total_att
                ')

            ->groupBy('district.district_id', 'district.district_name')
            ->orderBy('district.district_name')
            ->get();
        $end = microtime(true);
        $executionTime = $end - $start;
        // dd([
        //     'execution_time_seconds' => $executionTime,
        //     'execution_time_ms' => round($executionTime * 1000, 2),
        //     'data' => $districts
        // ]);
        echo $executionTime;


        $r_type ='district';


        return view('state.allregistration', compact(
            'userdata',
            'report', 'r_type'
        ));
    }

    public function cadreVenueMapping()
    {
        $userdata = auth()->user();

        $rows = DB::table('district')
            ->leftJoin('block', 'block.district_id', '=', 'district.district_id')
            ->leftJoin('gp', 'gp.block_id', '=', 'block.block_id')
            ->leftJoin('village', 'village.gp_id', '=', 'gp.gp_id')
            ->leftJoin('venue', 'venue.village_id', '=', 'village.vill_id')
            ->selectRaw('district.district_id, district.district_name,
                COUNT(DISTINCT venue.id) as total_venues,
                COALESCE(SUM(CASE WHEN venue.photo IS NOT NULL AND venue.photo != \'\' THEN 1 ELSE 0 END), 0) as photo_uploaded')
            ->groupBy('district.district_id', 'district.district_name')
            ->orderBy('district.district_name')
            ->get();

        return view('state.cadrevenuemapping', compact('userdata', 'rows'));
    }

    public function cadreVenueMappingDistrict($district_id)
    {
        $userdata = auth()->user();
        $district = District::where('district_id', $district_id)->firstOrFail();

        $rows = DB::table('block')
            ->leftJoin('gp', 'gp.block_id', '=', 'block.block_id')
            ->leftJoin('village', 'village.gp_id', '=', 'gp.gp_id')
            ->leftJoin('venue', 'venue.village_id', '=', 'village.vill_id')
            ->where('block.district_id', $district_id)
            ->selectRaw('block.block_id, block.block_name,
                COUNT(DISTINCT venue.id) as total_venues,
                COALESCE(SUM(CASE WHEN venue.photo IS NOT NULL AND venue.photo != \'\' THEN 1 ELSE 0 END), 0) as photo_uploaded')
            ->groupBy('block.block_id', 'block.block_name')
            ->orderBy('block.block_name')
            ->get();

        return view('state.cvm_block', compact('userdata', 'district', 'rows'));
    }

    public function cadreVenueMappingBlock($block_id)
    {
        $userdata = auth()->user();
        $block = Block::with('district')->where('block_id', $block_id)->firstOrFail();

        $rows = DB::table('gp')
            ->leftJoin('village', 'village.gp_id', '=', 'gp.gp_id')
            ->leftJoin('venue', 'venue.village_id', '=', 'village.vill_id')
            ->where('gp.block_id', $block_id)
            ->selectRaw('gp.gp_id, gp.gp_name,
                COUNT(DISTINCT venue.id) as total_venues,
                COALESCE(SUM(CASE WHEN venue.photo IS NOT NULL AND venue.photo != \'\' THEN 1 ELSE 0 END), 0) as photo_uploaded')
            ->groupBy('gp.gp_id', 'gp.gp_name')
            ->orderBy('gp.gp_name')
            ->get();

        return view('state.cvm_gp', compact('userdata', 'block', 'rows'));
    }

    public function cadreVenueMappingGp($gp_id)
    {
        $userdata = auth()->user();
        $gp = Gp::with('block.district')->where('gp_id', $gp_id)->firstOrFail();

        $rows = DB::table('village')
            ->leftJoin('venue', 'venue.village_id', '=', 'village.vill_id')
            ->where('village.gp_id', $gp_id)
            ->selectRaw('village.vill_id, village.vill_name,
                COUNT(DISTINCT venue.id) as total_venues,
                COALESCE(SUM(CASE WHEN venue.photo IS NOT NULL AND venue.photo != \'\' THEN 1 ELSE 0 END), 0) as photo_uploaded')
            ->groupBy('village.vill_id', 'village.vill_name')
            ->orderBy('village.vill_name')
            ->get();

        return view('state.cvm_village', compact('userdata', 'gp', 'rows'));
    }

    public function cadreVenueMappingVillage($village_id)
    {
        $userdata = auth()->user();
        $village = Village::with('gp.block.district')->where('vill_id', $village_id)->firstOrFail();
        $venues = Venue::with('cadre')->where('village_id', $village_id)->orderBy('venue_name')->get();

        return view('state.cvm_venues', compact('userdata', 'village', 'venues'));
    }

    public function districtDetails($district_id)
    {
        $userdata = auth()->user();
        $district = District::where('district_id', $district_id)->first();

        if (!$district) {
            return back()->with('error', 'District not found.');
        }

        $report = DB::table('block')          
            ->join('gp', 'gp.block_id', '=', 'block.block_id')
            ->join('village', 'village.gp_id', '=', 'gp.gp_id')
            ->join('shg', function ($join) {
                $join->on('shg.vill_id_new', '=', 'village.vill_id')
                    ->where('shg.shg_status', 1);
            })
            ->join('member', 'member.shg_code', '=', 'shg.shg_code')
            ->where('block.district_id', $district_id)
            ->selectRaw('
                block.block_id as id,
                block.block_name as name,
                SUM(CASE WHEN member.mem_status = 1 THEN 1 ELSE 0 END) as total_member,
                SUM(CASE WHEN member.mem_status = 1 AND member.yoga2026_registration = 1 THEN 1 ELSE 0 END) as total_reg,
                SUM(CASE WHEN member.mem_status = 1 AND member.yoga2026_registration = 1 and member.yoga_attendance=1 THEN 1 ELSE 0 END) as total_att
            ')

            ->groupBy('block.block_id', 'block.block_name')
            ->orderBy('block.block_name')
            ->get();
            $r_type ="block";

        return view('state.allregistration', compact('userdata', 'district', 'report','r_type'));
    }
    public function blockDetails($block_id)
    {
        $userdata = auth()->user();
        $block = Block::with('district')->where('block_id', $block_id)->first();

        if (!$block) {
            return back()->with('error', 'Block not found.');
        }

        $report = DB::table('gp')          
            ->join('village', 'village.gp_id', '=', 'gp.gp_id')
            ->join('shg', function ($join) {
                $join->on('shg.vill_id_new', '=', 'village.vill_id')
                    ->where('shg.shg_status', 1);
            })
            ->join('member', 'member.shg_code', '=', 'shg.shg_code')
            ->where('gp.block_id', $block_id)
            ->selectRaw('
                gp.gp_id as id,
                gp.gp_name as name,
                SUM(CASE WHEN member.mem_status = 1 THEN 1 ELSE 0 END) as total_member,
                SUM(CASE WHEN member.mem_status = 1 AND member.yoga2026_registration = 1 THEN 1 ELSE 0 END) as total_reg,
                  SUM(CASE WHEN member.mem_status = 1 AND member.yoga2026_registration = 1 and member.yoga_attendance=1 THEN 1 ELSE 0 END) as total_att
            ')

            ->groupBy('gp.gp_id', 'gp.gp_name')
            ->orderBy('gp.gp_name')
            ->get();
            $r_type="gp";
        return view('state.allregistration', compact('userdata', 'report','r_type'));
    }

    public function gpDetails($gp_id)
    {
        $userdata = auth()->user();
        $gp = Gp::with('block.district')->where('gp_id', $gp_id)->first();

        if (!$gp) {
            return back()->with('error', 'GP not found.');
        }

        $report = DB::table('village')          
            ->join('shg', function ($join) {
                $join->on('shg.vill_id_new', '=', 'village.vill_id')
                    ->where('shg.shg_status', 1);
            })
            ->join('member', 'member.shg_code', '=', 'shg.shg_code')
            ->where('village.gp_id', $gp_id)
            ->selectRaw('
                village.vill_id as id,
                village.vill_name as name,
                SUM(CASE WHEN member.mem_status = 1 THEN 1 ELSE 0 END) as total_member,
                SUM(CASE WHEN member.mem_status = 1 AND member.yoga2026_registration = 1 THEN 1 ELSE 0 END) as total_reg,
                  SUM(CASE WHEN member.mem_status = 1 AND member.yoga2026_registration = 1 and member.yoga_attendance=1 THEN 1 ELSE 0 END) as total_att
            ')

            ->groupBy('village.vill_id', 'village.vill_name')
            ->orderBy('village.vill_name')
            ->get();
            $r_type="village";

        return view('state.allregistration', compact('userdata', 'gp', 'report','r_type'));
    }

    public function villageDetails($village_id)
    {
        $userdata = auth()->user();
        $village = Village::with('gp.block.district')->where('vill_id', $village_id)->first();

        if (!$village) {
            return back()->with('error', 'Village not found.');
        }

        $report = DB::table('shg')          
            ->join('member', 'member.shg_code', '=', 'shg.shg_code')
            ->where('shg.vill_id_new', $village_id)
            ->where('shg.shg_status', 1)
            ->selectRaw('
                shg.shg_code as id,
                shg.shg_name as name,
                SUM(CASE WHEN member.mem_status = 1 THEN 1 ELSE 0 END) as total_member,
                SUM(CASE WHEN member.mem_status = 1 AND member.yoga2026_registration = 1 THEN 1 ELSE 0 END) as total_reg,
                SUM(CASE WHEN member.mem_status = 1 AND member.yoga2026_registration = 1 and member.yoga_attendance=1 THEN 1 ELSE 0 END) as total_att
            ')
            ->groupBy('shg.shg_code','shg.shg_name')
            ->orderBy('shg.shg_name')
            ->get();
            $r_type= 'shg';
        return view('state.allregistration', compact('userdata', 'village', 'report','r_type'));
    }

    public function shgDetails($shg_code)
    {
        $userdata = auth()->user();
        $shg = Shg::with('village.gp.block.district')->where('shg_code', $shg_code)->first();

        if (!$shg) {
            return back()->with('error', 'SHG not found.');
        }

        $members = ShgMember::where('shg_code', $shg_code)->orderBy('mem_name')->get();
        $total = $members->count();
        $registered = $members->where('yoga2026_registration', 1)->count();
        $notReg = $total - $registered;
        $percent = $total > 0 ? round(($registered / $total) * 100, 1) : 0;
        $attendancePresent = $members->where('yoga_attendance', 1)->count();

        return view('state.shgdetails', compact(
            'userdata',
            'shg',
            'members',
            'total',
            'registered',
            'notReg',
            'percent',
            'attendancePresent'
        ));
    }

    public function shgRegisteredMembers($shg_code)
    {
        $shg = Shg::with('village.gp.block.district')->where('shg_code', $shg_code)->first();

        if (!$shg) {
            return back()->with('error', 'SHG not found.');
        }

        $members = ShgMember::where('shg_code', $shg_code)
            ->where('yoga2026_registration', 1)
            ->orderBy('mem_name')
            ->get();

        // Build S3 prefix once from $shg (already eager-loaded with full chain)
        $s3Prefix = sprintf(
            'yoga_selfies/%s/%s/%s/%s/%s',
            $shg->village->gp->block->district_id,
            $shg->village->gp->block_id,
            $shg->village->gp_id,
            $shg->village->vill_id,
            $shg_code
        );

        /** @var \Illuminate\Filesystem\FilesystemAdapter $s3 */
        $s3 = Storage::disk('s3');
        $expiresAt = now()->addHours(1);

        $photoUrls = [];
        foreach ($members as $member) {
            if ($member->yoga_selfie) {
                try {
                    $photoUrls[$member->mem_no] = $s3->temporaryUrl(
                        "{$s3Prefix}/{$member->yoga_selfie}",
                        $expiresAt
                    );
                } catch (\Exception $e) {
                    $photoUrls[$member->mem_no] = null;
                }
            }
        }

        return view('state.shgregisteredmembers', compact('shg', 'members', 'photoUrls'));
    }
}
