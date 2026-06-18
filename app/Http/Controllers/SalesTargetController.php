<?php

namespace App\Http\Controllers;

use App\Models\SalesTarget;
use App\Models\User;
use Illuminate\Http\Request;

class SalesTargetController extends Controller
{
    public function index()
    {
        $targets = SalesTarget::with('sales')
            ->latest()
            ->paginate(10);

        return view('sales_targets.index', compact('targets'));
    }

    public function create()
    {
        $salesUsers = User::where('role', 'sales')
            ->orderBy('name')
            ->get();

        return view('sales_targets.create', compact('salesUsers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sales_id' => 'required|exists:users,id',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer',
            'target_amount' => 'required|numeric|min:0',
        ]);

        SalesTarget::updateOrCreate(
            [
                'sales_id' => $request->sales_id,
                'month' => $request->month,
                'year' => $request->year,
            ],
            [
                'target_amount' => $request->target_amount,
            ]
        );

        return redirect()
            ->route('sales-targets.index')
            ->with('success', 'Target sales berhasil disimpan.');
    }

    public function edit(SalesTarget $salesTarget)
    {
        $salesUsers = User::where('role', 'sales')
            ->orderBy('name')
            ->get();

        return view('sales_targets.edit', compact('salesTarget', 'salesUsers'));
    }

    public function update(Request $request, SalesTarget $salesTarget)
    {
        $request->validate([
            'sales_id' => 'required|exists:users,id',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer',
            'target_amount' => 'required|numeric|min:0',
        ]);

        $salesTarget->update([
            'sales_id' => $request->sales_id,
            'month' => $request->month,
            'year' => $request->year,
            'target_amount' => $request->target_amount,
        ]);

        return redirect()
            ->route('sales-targets.index')
            ->with('success', 'Target sales berhasil diupdate.');
    }

    public function destroy(SalesTarget $salesTarget)
    {
        $salesTarget->delete();

        return back()->with('success', 'Target sales berhasil dihapus.');
    }

    public function show(SalesTarget $salesTarget)
{
    return redirect()->route('sales-targets.edit', $salesTarget->id);
}
}