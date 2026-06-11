<?php

namespace App\Http\Controllers;

use App\Models\Analytics;

class HomePageController extends Controller
{
    public function live()
    {
        return view("yogaday2026.live");
    }
    public function index()
    {
        


        return view('yogaday2026.home');
    }
    public function analytics()
    {
        $analyticsRows = Analytics::all()
            ->sortByDesc(function ($row) {
                return $row->total > 0
                    ? ($row->count / $row->total)
                    : 0;
            })
            ->values();

        $districtStats = Analytics::all()
            ->map(function ($row) {
                return (object) [
                    'district_name' => $row->district_name,
                    'registered' => $row->count,
                    'total' => $row->total,
                    'percentage' => $row->total > 0
                        ? round(($row->count / $row->total) * 100, 2)
                        : 0,
                ];
            })
            ->sortByDesc('percentage')
            ->values();

        $totalRegistered = $analyticsRows->sum('count');
        $totalMembers = $analyticsRows->sum('total');
        $lastSynced = $analyticsRows->max('updated_at');


        $pct = $totalMembers > 0
            ? round(($totalRegistered / $totalMembers) * 100, 2)
            : 0;

        $maxRegistered = $districtStats->max('registered') ?: 1;


        return view('yogaday2026.analytics', compact(
            'districtStats',
            'totalRegistered',
            'totalMembers',
            'lastSynced',
            'pct',
            'maxRegistered'
        ));
    }
}
