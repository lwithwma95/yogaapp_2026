<?php

namespace App\Http\Controllers;

use App\Models\ShgMember;
use Illuminate\Http\Request;
use App\Models\Shg;
use App\Models\District;
use App\Models\Block;
use App\Models\Gp;
use App\Models\Village;
use App\Models\ShgMembers;
use Illuminate\Support\Facades\DB;
use App\Models\Venue;


class AjaxController extends Controller
{
    // DISTRICT -> BLOCK

    public function getBlocks($district_id)
    {
        $blocks = Block::where('district_id', $district_id)
            ->orderBy('block_name')
            ->get([
                'block_id',
                'block_name'
            ]);

        return response()->json($blocks);
    }

    // BLOCK -> GP

    public function getGps($block_id)
    {
        $gps = Gp::where('block_id', $block_id)
            ->orderBy('gp_name')
            ->get([
                'gp_id',
                'gp_name'
            ]);

        return response()->json($gps);
    }

    // GP -> VILLAGE

    public function getVillages($gp_id)
    {
        $villages = Village::where('gp_id', $gp_id)
            ->orderBy('vill_name')
            ->get([
                'vill_id',
                'vill_name'
            ]);

        return response()->json($villages);
    }

    // VILLAGE -> SHG

    public function getShgs($vill_id)
    {
        $shgs = Shg::where('vill_id_new', $vill_id)
            ->orderBy('shg_name')
            ->where('shg_status', 1)
            ->get([
                'shg_code',
                'shg_name'
            ]);

        return response()->json($shgs);
    }
    public function getmember($shg_code)
    {
        $member = ShgMember::where('shg_code', $shg_code)
            ->orderBy('mem_name')
            ->where('mem_status', 1)
            ->get([
                'mem_code',
                'mem_name',
                'mem_guard_name as guardian_name',
                'mem_uid',
                'yoga2026_registration',
                'yoga_attendance',
            ]);

        return response()->json($member);
    }
    public function getmemberDetails($mem_uid)
    {
        $memberdetails = ShgMember::query()
            ->where('member.mem_uid', $mem_uid)
            ->join('shg', DB::raw('`member`.`shg_code` COLLATE utf8mb4_general_ci'), '=', 'shg.shg_code')
            ->join('village', 'shg.vill_id_new', '=', 'village.vill_id')
            ->join('gp', 'village.gp_id', '=', 'gp.gp_id')
            ->join('block', 'gp.block_id', '=', 'block.block_id')
            ->join('district', 'block.district_id', '=', 'district.district_id')
            ->select([
                'member.mem_no',
                'member.mem_uid',
                'member.mem_code',
                'member.mem_name',
                'member.mem_guard_name as guardian_name',
                'member.mem_mobile',
                'member.yoga_selfie',
                'member.yoga2026_registration',
                'shg.shg_code',
                'shg.shg_name',
                'village.vill_name',
                'gp.gp_name',
                'block.block_name',
                'district.district_name',
            ])
            ->firstOrFail();

        return response()->json($memberdetails);
    }
    public function getShgsVenueMapped($vill_id)
    {
        $data = DB::table('shg')
            ->leftJoin('venue', 'venue.id', '=', 'shg.venue_id')
            ->where('shg.vill_id_new', $vill_id)
            ->where('shg.shg_status', 1)
            ->select(
                'shg.shg_code',
                'shg.shg_name',
                'shg.venue_id',
                'venue.venue_name'
            )
            ->orderBy('shg.shg_name')
            ->get();
        return response()->json($data);
    }
    public function checkVenueMonitor(Request $request)
    {
        try {

            $villageId = $request->village_id;
            $memberCodes = $request->member_codes ?? [];

            // Check if any of the selected members already monitors a venue in this village
            $existingVenue = Venue::where('village_id', $villageId)
                ->whereIn('monitored_by', $memberCodes)
                ->first();

            if ($existingVenue) {

                // Fetch member name from members table
                $member = Shgmember::where('mem_code', $existingVenue->monitored_by)->first();
                $memberName = $member ? $member->mem_name : $existingVenue->monitored_by;

                return response()->json([
                    'already_mapped' => true,
                    'message' => '"' . $memberName . '" is already assigned as monitor for venue "' . $existingVenue->venue_name . '".',
                ]);
            }

            return response()->json([
                'already_mapped' => false,
                'message' => null,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ], 500);
        }
    }
    public function checkVillageVenue(Request $request)
    {
        try {

            $villageId = $request->village_id;
            $memberCodes = $request->member_codes ?? [];
            $excludeVenueId = $request->exclude_venue_id; // passed only on update

            // Check if any member is already monitoring another venue
            if (!empty($memberCodes)) {

                $existingVenue = Venue::whereIn('monitored_by', $memberCodes)
                    ->when($excludeVenueId, fn($q) => $q->where('id', '!=', $excludeVenueId))
                    ->first();

                if ($existingVenue) {

                    $member = Shgmember::where('mem_code', $existingVenue->monitored_by)->first();
                    $memberName = $member ? $member->mem_name : $existingVenue->monitored_by;

                    return response()->json([
                        'exists' => true,
                        'message' => '"' . $memberName . '" is already assigned as monitor for another venue.',
                    ]);
                }
            }

            return response()->json([
                'exists' => false,
                'message' => null,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ], 500);
        }
    }
}


