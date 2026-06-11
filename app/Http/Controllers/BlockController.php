<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShgMember;
use App\Models\Venue;
use App\Models\User;
use App\Models\Block;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Village;
use App\Models\Shg;
use App\Models\Gp;

class BlockController extends Controller
{
    public function viewyogaregistrations()
    {
        return view('block.viewregistrationsbyshg');
    }


    public function viewRegistrationsGPWise()
    {
        $userdata = auth()->user()->block;
        $block_id = $userdata;
        // echo $block_id;
        $query = DB::table('gp')
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
            ->orderBy('gp.gp_name');

        // dd($query->toRawSql());

        $gpRows = $query->get();

        $total = $gpRows->sum('total');
        $registered = $gpRows->sum('registered');

        $totalAttendance = $gpRows->sum('attendance');
        $active_page = 'registrations';
        return view('block.viewregistrationgpwise', compact(
            'userdata',
            'gpRows',
            'total',
            'registered',
            'totalAttendance',
            'active_page'
        ));

    }

    public function viewRegistrationsVillageWise($gp_id)
    {
        $userdata = auth()->user();



        $villagerows = DB::table('village')
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
        COALESCE(SUM(member.yoga2026_registration = 1), 0) AS registered,
        COALESCE(SUM(member.yoga_attendance = 1), 0) AS attendance
    ")
            ->groupBy('village.vill_id', 'village.vill_name')
            ->orderBy('village.vill_name')
            ->get();


        $active_page = 'registrations';

        $total = $villagerows->sum('total');
        $registered = $villagerows->sum('registered');
        $totalAttendance = $villagerows->sum('attendance');

        $active_page = 'registrations';


        return view('block.viewregistrationvillagewise', compact('userdata', 'villagerows', 'total', 'registered', 'totalAttendance', 'active_page'));
    }

    public function viewRegistrationsSHGWise($village_id)
    {
        $userdata = auth()->user();

        $village = Village::with('gp')
            ->where('vill_id', $village_id)
            ->first();

        if (
            !$village ||
            !$village->gp ||
            $village->gp->block_id != $userdata->block
        ) {
            return back()->with('error', 'Access denied.');
        }

        $block = auth()->user()->block;
        $gp = $village->gp;

        $rows = DB::table('shg')
            ->leftJoin('member', function ($join) {
                $join->on('member.shg_code', '=', 'shg.shg_code')
                    ->where('member.mem_status', 1);
            })
            ->where('shg.vill_id_new', $village_id)
            ->where('shg.shg_status', 1)
            ->where('shg.shg_code', '!=', 0)
            ->selectRaw("
            shg.shg_code,
            shg.shg_name,
            COUNT(member.mem_no) AS total,
            COALESCE(SUM(member.yoga2026_registration = 1), 0) AS registered,
            COALESCE(SUM(member.yoga_attendance = 1), 0) AS attendance
        ")
            ->groupBy(
                'shg.shg_code',
                'shg.shg_name'
            )
            ->orderBy('shg.shg_name')
            ->get();

        $total = $rows->sum('total');
        $registered = $rows->sum('registered');
        $notReg = $total - $registered;
        $percent = $total > 0
            ? round(($registered / $total) * 100, 1)
            : 0;
        $totalAttendance = $rows->sum('attendance');

        return view('block.viewregistrationshgwise', compact(
            'block',
            'gp',
            'village',
            'rows',
            'total',
            'registered',
            'notReg',
            'percent',
            'totalAttendance'
        ));
    }

    public function viewSHGRegisteredMembers($shg_code)
    {
        $userdata = auth()->user();
        $shg = Shg::with('village.gp.block')->where('shg_code', $shg_code)->first();

        if (!$shg || $shg->village->gp->block_id != $userdata->block) {
            return back()->with('error', 'Access denied.');
        }

        $members = ShgMember::with(['shg.village.gp.block.district'])
            ->where('shg_code', $shg_code)

            ->orderBy('mem_name')
            ->get();

        return view('block.viewshgregisteredmembers', compact('shg', 'members'));
    }

    public function venueregistration()
    {
        $userdata = auth()->user();
        $activepage = "venue_reg";

        return view('block.venueregistration', compact('userdata', 'activepage'));
    }
    public function storeVenue(Request $request)
    {

        $request->validate([
            'vill_id' => 'required|exists:village,vill_id',
            'venue_name' => 'required|array',
            'venue_name.*' => 'required|string|max:255',
            'capacity' => 'required|array',
            'capacity.*' => 'required|integer|min:1',
            'shg' => 'required|array',
            'shg.*' => 'required',
            'memberid' => 'required|array',
            'memberid.*' => 'required|exists:member,mem_code',
        ]);


        // CHECK IF VILLAGE ALREADY HAS VENUE

        // $exists = Venue::where(
        //     'village_id',
        //     $request->vill_id
        // )->exists();

        // if ($exists) {

        //     return back()->with(
        //         'error',
        //         'Venue already registered for this village.'
        //     );

        // }

        // LOOP THROUGH ALL ROWS

        foreach ($request->venue_name as $key => $venueName) {

            // SKIP EMPTY ROWS

            if (
                empty($venueName) ||
                empty($request->capacity[$key]) ||
                empty($request->shg[$key]) ||
                empty($request->memberid[$key])
            ) {

                continue;

            }
            // GET MEMBER DETAILS
            $member = ShgMember::where(
                'mem_code',
                $request->memberid[$key]
            )->first();

            if (!$member) {

                continue;

            }

            // CREATE CADRE USER IF NOT EXISTS
            if (!User::where('email', $member->mem_code . '@asrlm.in')->exists()) {
                User::create([
                    'name' => $member->mem_code,
                    'district' => auth()->user()->district,
                    'block' => auth()->user()->block,
                    'email' => $member->mem_code . '@asrlm.in',
                    'password' => Hash::make('Pass@123'),
                    'role' => 'cadre',
                ]);
            }

            // INSERT VENUE

            Venue::create([
                'village_id' => $request->vill_id,
                'venue_name' => $venueName,
                'capacity' => $request->capacity[$key],
                'shg_code' => $request->shg[$key],
                'monitored_by' => $member->mem_code,
            ]);

        }

        return back()->with(
            'success',
            'Venue Registration and Cadre Mapping Completed Successfully.'
        );

    }

    public function getVenuesByMember($mem_code)
    {
        $venues = Venue::with(['village.gp', 'shg'])
            ->where('monitored_by', $mem_code)
            ->get();

        return response()->json(
            $venues->map(function ($v) {
                return [
                    'id' => $v->id,
                    'village_id' => $v->village_id,
                    'village_name' => optional($v->village)->vill_name ?? 'N/A',
                    'gp_id' => optional(optional($v->village)->gp)->gp_id ?? null,
                    'venue_name' => $v->venue_name,
                    'capacity' => $v->capacity,
                    'shg_code' => $v->shg_code,
                    'shg_name' => optional($v->shg)->shg_name ?? $v->shg_code,
                    'monitored_by' => $v->monitored_by,
                ];
            })
        );
    }

    public function updateVenue(Request $request)
    {
        $request->validate([
            'venue_ids' => 'required|array',
            'venue_ids.*' => 'required|exists:venue,id',
            'venue_name' => 'required|array',
            'venue_name.*' => 'required|string|max:255',
            'capacity' => 'required|array',
            'capacity.*' => 'required|integer|min:1',
            'shg' => 'required|array',
            'shg.*' => 'required|string',
            'memberid' => 'required|array',
            'memberid.*' => 'required|exists:member,mem_code',
        ]);

        foreach ($request->venue_ids as $key => $venueId) {

            $venue = Venue::find($venueId);
            if (!$venue)
                continue;

            $member = ShgMember::where('mem_code', $request->memberid[$key])->first();
            if (!$member)
                continue;

            // CREATE CADRE USER IF NOT EXISTS
            if (!User::where('email', $member->mem_code . '@asrlm.in')->exists()) {
                User::create([
                    'name' => $member->mem_code,
                    'district' => auth()->user()->district,
                    'block' => auth()->user()->block,
                    'email' => $member->mem_code . '@asrlm.in',
                    'password' => Hash::make('Pass@123'),
                    'role' => 'cadre',
                ]);
            }

            $venue->update([
                'venue_name' => $request->venue_name[$key],
                'capacity' => $request->capacity[$key],
                'shg_code' => $request->shg[$key],
                'monitored_by' => $member->mem_code,
            ]);
        }

        return redirect()->route('cadre.mapping')
            ->with('success', 'Venue assignment updated successfully.');
    }

    public function cadrevenue()
    {
        $userdata = auth()->user();

        $venues = Venue::with('village')
            ->join('village', 'village.vill_id', '=', 'venue.village_id')
            ->join('gp', 'gp.gp_id', '=', 'village.gp_id')
            ->where('gp.block_id', auth()->user()->block)
            ->select(
                'venue.*',
                'gp.gp_name'
            )
            ->selectSub(function ($q) {
                $q->from('shg')
                    ->join('member', 'member.shg_code', '=', 'shg.shg_code')
                    ->whereColumn('shg.venue_id', 'venue.id')
                    ->where('member.yoga2026_registration', 1)
                    ->selectRaw('COUNT(member.mem_code)');
            }, 'registered_member_count')
            ->get();

        $cadreMembers = collect();
        $cadreNameMap = collect();
        User::where('role', 'cadre')->where('block', $userdata->block)
            ->each(function ($cadre) use ($cadreMembers, $cadreNameMap) {
                $memCode = explode('@', $cadre->email)[0];
                $cadreNameMap->put($memCode, $cadre->name);
                $member = ShgMember::where('mem_code', $memCode)->first(['mem_code', 'mem_name']);
                if ($member)
                    $cadreMembers->push($member);
            });

        return view('block.cadrevenuemapping', compact('userdata', 'venues', 'cadreMembers', 'cadreNameMap'));
    }

    public function updateVenueCadre(Request $request)
    {
        $request->validate([
            'venue_id' => 'required|exists:venue,id',
            'mem_code' => 'required|exists:member,mem_code',
        ]);

        $venue = Venue::find($request->venue_id);
        $member = ShgMember::where('mem_code', $request->mem_code)->first();

        if (!$member) {
            return back()->with('error', 'Member not found.');
        }

        if (!User::where('email', $member->mem_code . '@asrlm.in')->exists()) {
            User::create([
                'name' => $member->mem_code,
                'district' => auth()->user()->district,
                'block' => auth()->user()->block,
                'email' => $member->mem_code . '@asrlm.in',
                'password' => Hash::make('Pass@123'),
                'role' => 'cadre',
            ]);
        }

        $venue->update(['monitored_by' => $member->mem_code]);

        return back()->with('success', 'Cadre updated successfully.');
    }

    public function deleteVenue(Request $request)
    {
        $request->validate([
            'venue_id' => 'required|exists:venue,id',
        ]);

        $venue = Venue::find($request->venue_id);

        if ($venue->monitored_by) {
            User::where('email', $venue->monitored_by . '@asrlm.in')->delete();
        }

        // Clear venue assignment from all SHGs linked to this venue
        Shg::where('venue_id', $venue->id)->update(['venue_id' => null]);

        $venue->delete();

        return back()->with('success', 'Venue deleted, cadre credentials removed, and SHG assignments cleared.');
    }

    public function shgMappingVenue($venue_id)
    {
        $userdata = auth()->user();

        $venue = Venue::with([
            'village.gp',
            'cadre'
        ])->findOrFail($venue_id);

        $mappedShgCount = DB::table('shg')
            ->where('venue_id', $venue_id)
            ->count();

        return view(
            'block.shgmapping',
            compact(
                'venue',
                'userdata',
                'mappedShgCount'
            )
        );
    }

    public function saveShgVenueMapping(Request $request)
    {
        $request->validate([
            'venue_id' => 'required|exists:venue,id',
            'selected_shgs' => 'nullable|array',
            'selected_shgs.*' => 'in:0,1',
        ]);

        $venueId = $request->venue_id;
        $selectedShgs = $request->selected_shgs ?? [];

        // SHG codes with value 1 → assign to venue
        $toAssign = array_keys(array_filter($selectedShgs, fn($v) => $v == '1'));

        // SHG codes with value 0 → unassign (set to 0)
        $toUnassign = array_keys(array_filter($selectedShgs, fn($v) => $v == '0'));

        // Unmap untoggled SHGs
        if (!empty($toUnassign)) {
            Shg::whereIn('shg_code', $toUnassign)
                ->update(['venue_id' => 0]);
        }

        // Map toggled ON SHGs
        if (!empty($toAssign)) {
            Shg::whereIn('shg_code', $toAssign)
                ->where(function ($q) use ($venueId) {
                    $q->where('venue_id', 0)
                        ->orWhereNull('venue_id')
                        ->orWhere('venue_id', $venueId);
                })
                ->update(['venue_id' => $venueId]);
        }

        return back()->with(
            'success',
            'SHG mapping updated successfully.'
        );
    }
    public function shgMapping()
    {
        $userdata = auth()->user();

        // GPs under this block
        $gps = Gp::where('block_id', $userdata->block)
            ->orderBy('gp_name')
            ->get(['gp_id', 'gp_name']);

        // Cadre members under this block
        $cadreMembers = collect();
        User::where('role', 'cadre')->where('block', $userdata->block)
            ->each(function ($cadre) use ($cadreMembers) {
                $memCode = explode('@', $cadre->email)[0];
                $member = ShgMember::where('mem_code', $memCode)->first(['mem_code', 'mem_name']);
                if ($member)
                    $cadreMembers->push($member);
            });

        $preGpId = request('gp_id');
        $preVillId = request('vill_id');
        $preVenue = null;

        if (request('venue_id')) {
            $preVenue = Venue::with(['village.gp', 'shg'])->find(request('venue_id'));
            if ($preVenue) {
                $preVillId = $preVenue->village_id;
                $preGpId = optional(optional($preVenue->village)->gp)->gp_id ?? $preGpId;
                $preVenueCadre = $preVenue->monitored_by
                    ? ShgMember::where('mem_code', $preVenue->monitored_by)
                        ->first(['mem_code', 'mem_name', 'mem_mobile'])
                    : null;
            }
        }

        return view('block.shgmapping', compact(
            'userdata',
            'gps',
            'cadreMembers',
            'preGpId',
            'preVillId',
            'preVenue',
            'preVenueCadre'
        ));
    }

    public function getSHGsForMapping($vill_id)
    {
        $shgs = Shg::where('vill_id_new', $vill_id)
            ->orderBy('shg_name')
            ->get(['shg_code', 'shg_name', 'venue_id']);

        // All registered cadres (yoga_cadre=1) in the same block as this village
        $village = Village::with('gp')->where('vill_id', $vill_id)->first();
        $blockId = optional(optional($village)->gp)->block_id;

        $cadreMembers = ShgMember::where('yoga_cadre', 1)
            ->whereHas('shg.village.gp', function ($q) use ($blockId) {
                $q->where('block_id', $blockId);
            })
            ->get(['mem_code', 'mem_name']);

        $shgList = $shgs->map(function ($shg) {
            return [
                'shg_code' => $shg->shg_code,
                'shg_name' => $shg->shg_name,
                'cadre_code' => $shg->venue_id,
            ];
        });

        return response()->json([
            'shgs' => $shgList,
            'cadres' => $cadreMembers,
        ]);
    }

    public function saveSHGMapping(Request $request)
    {
        $request->validate([
            'vill_id' => 'required',
            'mappings' => 'required|array',
            'mappings.*.shg_code' => 'required',
            'mappings.*.cadre_code' => 'nullable|string',
        ]);

        foreach ($request->mappings as $map) {
            if (empty($map['cadre_code']))
                continue;

            Shg::where('shg_code', $map['shg_code'])
                ->update(['venue_id' => $map['cadre_code']]);
        }

        return response()->json(['success' => true, 'message' => 'SHG mapping saved successfully.']);
    }
    // CONTROLLER FUNCTION
    public function mappedShgs($village_id)
    {
        $userdata = auth()->user();

        // GET VILLAGE DETAILS

        $village = Village::with([
            'gp',
        ])->where(
                'vill_id',
                $village_id
            )->first();

        if (!$village) {

            return back()->with(
                'error',
                'Village not found.'
            );
        }
        // GET SHGs UNDER THIS VILLAGE
        $shgs = Shg::withCount([
            // TOTAL MEMBERS
            'members as total_members',
            // REGISTERED MEMBERS
            'members as registered_members' => function ($query) {

                $query->where(
                    'yoga2026_registration',
                    1
                );
            }

        ])
            ->where(
                'vill_id_new',
                $village_id
            )
            ->orderBy(
                'shg_name',
                'asc'
            )
            ->get();

        return view('block.viewyogamapvillages', compact('village', 'shgs'));
    }
    public function viewMappedRegMember($gp_name, $village_name, $venue_name, $venue_id)
    {
        $members = DB::table('member')
            ->join('shg', 'member.shg_code', '=', 'shg.shg_code')
            ->where('shg.venue_id', $venue_id)
            ->where('member.yoga2026_registration', 1)
            ->select(
                'member.*',
                'shg.shg_name',
                'shg.shg_code'
            )
            ->get();

        return view('block.mapped_reg_member', compact(
            'members',
            'gp_name',
            'venue_name',
            'village_name'
        ));
    }
    public function viewMappedShgs($venue_id)
    {

        $shgs = DB::table('shg')
            ->join('village', 'village.vill_id', '=', 'shg.vill_id_new')
            ->join('gp', 'gp.gp_id', '=', 'village.gp_id')
            ->join('venue', 'venue.id', '=', 'shg.venue_id')
            ->where('shg.venue_id', $venue_id)
            ->select(
                'gp.gp_name',
                'village.vill_name',
                'venue.venue_name',
                'shg.shg_code',
                'shg.shg_name'
            )
            ->orderBy('gp.gp_name')
            ->orderBy('village.vill_name')
            ->orderBy('shg.shg_name')
            ->get();

        return view('block.mapped_shgs', compact('shgs'));
    }
    public function editVenue($venue_id)
    {
        $userdata = auth()->user();

        $venue = Venue::find($venue_id);

        // Guard: venue not found
        if (!$venue) {
            return redirect()->route('edit.venue')
                ->with('error', 'Venue not found.');
        }

        return view('block.editvenue', compact('userdata', 'venue'));
    }
    public function editVenuestore(Request $request, $id)
{
    $request->validate([
        'venue_name' => 'required|string|max:255',
        'capacity' => 'required|int',
    ]);

    $venue = Venue::findOrFail($id);

    $venue->update([
        'venue_name' => $request->venue_name,
        'capacity' => $request->capacity,
    ]);

    return redirect()->route('cadre.mapping')->with('success', 'Venue updated successfully.');
}
}
