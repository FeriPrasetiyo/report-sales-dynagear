<?php

namespace App\Http\Controllers;

use App\Models\SalesReport;
use App\Models\User;
use App\Models\SalesTarget;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $year = request('year', date('Y'));
        $monthFilter = request('month');
        $targetMonth = $monthFilter ?: date('n');

        $query = SalesReport::query();

        if (Auth::user()->role === 'sales') {
            $query->where('sales_id', Auth::id());
        }

        $query->whereYear('tanggal', $year);

        if ($monthFilter) {
            $query->whereMonth('tanggal', $monthFilter);
        }

        $totalReport = (clone $query)->count();
        $totalDeal = (clone $query)->where('status', 'deal')->count();
        $totalNoDeal = (clone $query)->where('status', 'no_deal')->count();
        $totalPending = (clone $query)->where('status', 'pending')->count();

        $nilaiDeal = (clone $query)->where('status', 'deal')->sum('total');

        $followUpToday = (clone $query)
            ->whereDate('next_followup_date', today())
            ->count();

        $latestReports = (clone $query)
            ->with('sales')
            ->latest()
            ->limit(5)
            ->get();

        $totalSales = User::where('role', 'sales')->count();

        $monthlyDeals = [];
        $monthlyNoDeals = [];

        for ($month = 1; $month <= 12; $month++) {
            $monthlyQuery = SalesReport::query();

            if (Auth::user()->role === 'sales') {
                $monthlyQuery->where('sales_id', Auth::id());
            }

            $monthlyDeals[] = (clone $monthlyQuery)
                ->where('status', 'deal')
                ->whereMonth('tanggal', $month)
                ->whereYear('tanggal', $year)
                ->count();

            $monthlyNoDeals[] = (clone $monthlyQuery)
                ->where('status', 'no_deal')
                ->whereMonth('tanggal', $month)
                ->whereYear('tanggal', $year)
                ->count();
        }

        $targetSales = null;
        $dealAmount = 0;
        $progressPercent = 0;

        if (Auth::user()->role === 'sales') {
            $targetSales = SalesTarget::where('sales_id', Auth::id())
                ->where('month', $targetMonth)
                ->where('year', $year)
                ->first();

            $dealAmount = SalesReport::where('sales_id', Auth::id())
                ->where('status', 'deal')
                ->whereMonth('tanggal', $targetMonth)
                ->whereYear('tanggal', $year)
                ->sum('total');

            if ($targetSales && $targetSales->target_amount > 0) {
                $progressPercent = round(($dealAmount / $targetSales->target_amount) * 100);
            }
        }

        $targetRanking = collect();
        $salesChartLabels = [];
        $salesChartData = [];

        if (Auth::user()->role !== 'sales') {
            $salesUsers = User::where('role', 'sales')
                ->orderBy('name')
                ->get();

            $targetRanking = $salesUsers->map(function ($sales) use ($year, $targetMonth) {
                $target = SalesTarget::where('sales_id', $sales->id)
                    ->where('month', $targetMonth)
                    ->where('year', $year)
                    ->first();

                $deal = SalesReport::where('sales_id', $sales->id)
                    ->where('status', 'deal')
                    ->whereMonth('tanggal', $targetMonth)
                    ->whereYear('tanggal', $year)
                    ->sum('total');

                $progress = 0;

                if ($target && $target->target_amount > 0) {
                    $progress = round(($deal / $target->target_amount) * 100);
                }

                return [
                    'name' => $sales->name,
                    'target' => $target?->target_amount ?? 0,
                    'deal' => $deal,
                    'progress' => $progress,
                ];
            })
            ->sortByDesc('progress')
            ->take(5);

            foreach ($salesUsers as $sales) {
                $salesChartLabels[] = $sales->name;

                $salesChartData[] = SalesReport::where('sales_id', $sales->id)
                    ->where('status', 'deal')
                    ->whereYear('tanggal', $year)
                    ->when($monthFilter, function ($q) use ($monthFilter) {
                        $q->whereMonth('tanggal', $monthFilter);
                    })
                    ->sum('total');
            }
        }

        return view('dashboard', compact(
            'year',
            'monthFilter',
            'totalReport',
            'totalDeal',
            'totalNoDeal',
            'totalPending',
            'nilaiDeal',
            'followUpToday',
            'latestReports',
            'totalSales',
            'monthlyDeals',
            'monthlyNoDeals',
            'targetSales',
            'dealAmount',
            'progressPercent',
            'targetRanking',
            'salesChartLabels',
            'salesChartData'
        ));
    }
}