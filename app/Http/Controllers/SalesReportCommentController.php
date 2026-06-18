<?php

namespace App\Http\Controllers;

use App\Models\SalesReport;
use App\Models\SalesReportComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesReportCommentController extends Controller
{
    public function store(Request $request, SalesReport $salesReport)
{
    $request->validate([
        'comment' => 'required|string',
    ]);

    $salesReport->comments()->create([
        'user_id' => auth()->id(),
        'comment' => $request->comment,
    ]);

    return back()->with('success', 'Komentar berhasil ditambahkan.');
}
}