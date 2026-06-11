<?php

namespace App\Http\Controllers;

use App\Models\Shg;
use App\Models\ShgMember;
use App\Models\Venue;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function blockDashboard()
    {
        $userdata  = auth()->user();
        $blockId   = $userdata->block;

        $block     = DB::table('block')->where('block_id', $blockId)->first();
        

        $totalShg          = (int) ($analytics->total_shg  ?? 0);
        $totalMembers      = (int) ($analytics->total      ?? 0);
        $registeredYoga    = (int) ($analytics->registered ?? 0);
        $attendanceMarked  = (int) ($analytics->attendance ?? 0);
        $unregisteredYoga  = $totalMembers - $registeredYoga;
        $percentRegistered = $totalMembers > 0
            ? round(($registeredYoga / $totalMembers) * 100, 1)
            : 0;

        return view('block.dashboard', compact(
            'block',
            'totalShg', 'totalMembers', 'registeredYoga',
            'unregisteredYoga', 'percentRegistered', 'attendanceMarked'
        ));
    }
    public function cadreDashboard()
    {
        $userdata = auth()->user();
        $memCode = $userdata->name;

        $memberName = ShgMember::where('mem_code', $memCode)
            ->value('mem_name');

        $venue = Venue::where('monitored_by', $memCode)
            ->first();

        $totalShgs = 0;
        $totalMembers = 0;
        $registeredMembers = 0;
        $unregisteredMembers = 0;
        $attendanceMarked = 0;
        $shgStats = collect();

        if ($venue) {

            $venueShgs = Shg::where('venue_id', $venue->id)
                ->select('shg_code', 'shg_name')
                ->where('shg.shg_status',1)
                ->get();

            $shgCodes = $venueShgs->pluck('shg_code');

            $totalShgs = $venueShgs->count();

            // Single query for all member statistics
            $memberStats = ShgMember::whereIn('shg_code', $shgCodes)
                ->selectRaw("
            shg_code,
            COUNT(*) as total_members,
            SUM(yoga2026_registration = 1) as registered_members,
            SUM(yoga_attendance = 1) as attendance_marked
        ")
                ->groupBy('shg_code')
                ->get()
                ->keyBy('shg_code');

            $totalMembers = $memberStats->sum('total_members');

            $registeredMembers = $memberStats->sum('registered_members');

            $attendanceMarked = $memberStats->sum('attendance_marked');

            $unregisteredMembers = $totalMembers - $registeredMembers;

            $shgStats = $venueShgs->map(function ($shg) use ($memberStats) {

                $stats = $memberStats->get($shg->shg_code);

                $total = $stats?->total_members ?? 0;
                $registered = $stats?->registered_members ?? 0;

                return [
                    'name' => $shg->shg_name,
                    'registered' => $registered,
                    'unregistered' => $total - $registered,
                ];
            });
        }

        return view('cadre.dashboard', compact(
            'userdata',
            'memberName',
            'venue',
            'totalShgs',
            'totalMembers',
            'registeredMembers',
            'unregisteredMembers',
            'attendanceMarked',
            'shgStats'
        ));
    }

    // public function districtDashboard()
    // {
    //     return app(DistrictController::class)->dashboard();
    // }

    // public function stateDashboard()
    // {
    //     return app(StateController::class)->dashboard();
    // }
}