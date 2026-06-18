<?php

namespace App\Http\Controllers;

use App\Models\SalesReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesReportController extends Controller
{
    public function index(Request $request)
    {
        $query = SalesReport::with('sales')->latest();

        /*
        |--------------------------------------------------------------------------
        | SALES
        |--------------------------------------------------------------------------
        | Sales hanya melihat report miliknya sendiri.
        */
        if (Auth::user()->role === 'sales') {
            $query->where('sales_id', Auth::id());
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('sales_id') && Auth::user()->role !== 'sales') {
            $query->where('sales_id', $request->sales_id);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('customer_name', 'like', '%' . $request->search . '%')
                    ->orWhere('no_sq', 'like', '%' . $request->search . '%')
                    ->orWhere('no_po', 'like', '%' . $request->search . '%');
            });
        }

        $reports = $query->paginate(10)->withQueryString();

        $salesUsers = User::where('role', 'sales')
            ->orderBy('name')
            ->get();

        return view('sales_reports.index', compact('reports', 'salesUsers'));
    }

    public function create()
    {
        $salesUsers = User::where('role', 'sales')
            ->orderBy('name')
            ->get();

        return view('sales_reports.create', compact('salesUsers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'no_sq' => 'nullable|string|max:255',
            'no_po' => 'nullable|string|max:255',
            'customer_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'qty' => 'required|integer|min:1',
            'price_unit' => 'required|numeric|min:0',
            'status' => 'required|in:pending,deal,no_deal',
            'sales_comment' => 'nullable|string',
            'next_followup_date' => 'nullable|date',
        ]);

        $salesId = Auth::id();

        if (Auth::user()->role !== 'sales' && $request->filled('sales_id')) {
            $salesId = $request->sales_id;
        }

        SalesReport::create([
            'sales_id' => $salesId,
            'tanggal' => $request->tanggal,
            'no_sq' => $request->no_sq,
            'no_po' => $request->no_po,
            'customer_name' => $request->customer_name,
            'description' => $request->description,
            'qty' => $request->qty,
            'price_unit' => $request->price_unit,
            'total' => $request->qty * $request->price_unit,
            'status' => $request->status,
            'sales_comment' => $request->sales_comment,
            'next_followup_date' => $request->next_followup_date,
        ]);

        return redirect()
            ->route('sales-reports.index')
            ->with('success', 'Report sales berhasil ditambahkan.');
    }

    public function show(SalesReport $salesReport)
    {
        /*
        |--------------------------------------------------------------------------
        | DETAIL REPORT
        |--------------------------------------------------------------------------
        | Sales boleh masuk detail agar bisa melihat komentar dan membalas komentar.
        | Data yang muncul di index sales tetap dibatasi hanya miliknya sendiri.
        */
        $salesReport->load('sales', 'comments.user');

        return view('sales_reports.show', compact('salesReport'));
    }

    public function edit(SalesReport $salesReport)
    {
        /*
        |--------------------------------------------------------------------------
        | EDIT REPORT
        |--------------------------------------------------------------------------
        | Sales boleh masuk halaman edit, tetapi di view hanya muncul form ubah status.
        | Admin dan Manager tetap bisa edit data lengkap.
        */
        $salesUsers = User::where('role', 'sales')
            ->orderBy('name')
            ->get();

        return view('sales_reports.edit', compact('salesReport', 'salesUsers'));
    }

    public function update(Request $request, SalesReport $salesReport)
    {
        /*
        |--------------------------------------------------------------------------
        | SALES
        |--------------------------------------------------------------------------
        | Sales hanya boleh mengubah status:
        | pending / deal / no_deal
        */
        if (Auth::user()->role === 'sales') {
            $request->validate([
                'status' => 'required|in:pending,deal,no_deal',
            ]);

            $salesReport->update([
                'status' => $request->status,
            ]);

            return redirect()
                ->route('sales-reports.index')
                ->with('success', 'Status report berhasil diubah.');
        }

        /*
        |--------------------------------------------------------------------------
        | ADMIN / MANAGER
        |--------------------------------------------------------------------------
        | Admin dan Manager boleh mengubah semua data report.
        */
        $request->validate([
            'tanggal' => 'required|date',
            'sales_id' => 'nullable|exists:users,id',
            'no_sq' => 'nullable|string|max:255',
            'no_po' => 'nullable|string|max:255',
            'customer_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'qty' => 'required|integer|min:1',
            'price_unit' => 'required|numeric|min:0',
            'status' => 'required|in:pending,deal,no_deal',
            'sales_comment' => 'nullable|string',
            'next_followup_date' => 'nullable|date',
        ]);

        $salesId = $salesReport->sales_id;

        if ($request->filled('sales_id')) {
            $salesId = $request->sales_id;
        }

        $salesReport->update([
            'sales_id' => $salesId,
            'tanggal' => $request->tanggal,
            'no_sq' => $request->no_sq,
            'no_po' => $request->no_po,
            'customer_name' => $request->customer_name,
            'description' => $request->description,
            'qty' => $request->qty,
            'price_unit' => $request->price_unit,
            'total' => $request->qty * $request->price_unit,
            'status' => $request->status,
            'sales_comment' => $request->sales_comment,
            'next_followup_date' => $request->next_followup_date,
        ]);

        return redirect()
            ->route('sales-reports.index')
            ->with('success', 'Report sales berhasil diupdate.');
    }

    public function destroy(SalesReport $salesReport)
    {
        /*
        |--------------------------------------------------------------------------
        | SALES TIDAK BOLEH HAPUS REPORT
        |--------------------------------------------------------------------------
        */
        if (Auth::user()->role === 'sales') {
            abort(403, 'Sales tidak boleh menghapus report.');
        }

        $salesReport->delete();

        return redirect()
            ->route('sales-reports.index')
            ->with('success', 'Report sales berhasil dihapus.');
    }
}