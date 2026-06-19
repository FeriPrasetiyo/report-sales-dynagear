<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Print Report Sales</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #000;
            margin: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h2 {
            margin: 0 0 5px 0;
            font-size: 20px;
        }

        .summary {
            margin-bottom: 15px;
        }

        .summary table,
        .report-table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary th,
        .summary td,
        .report-table th,
        .report-table td {
            border: 1px solid #000;
            padding: 6px;
        }

        .summary th {
            background: #f2f2f2;
            text-align: left;
        }

        .report-table th {
            background: #d9d9d9;
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .ttd {
            margin-top: 50px;
            width: 100%;
        }

        .ttd td {
            border: none;
            text-align: center;
            height: 90px;
            vertical-align: bottom;
        }

        .no-print {
            margin-bottom: 15px;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<div class="no-print">
    <button onclick="window.print()">
        Cetak / Save PDF
    </button>
</div>

<div class="header">
    <h2>REPORT SALES</h2>
    <div>PT Dynagear Pandu Pratama</div>
</div>

<div class="summary">
    <table>
        <tr>
            <th width="25%">Total Pendapatan Deal</th>
            <td>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>

            <th width="25%">Total Pending</th>
            <td>Rp {{ number_format($totalPending, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Total No Deal</th>
            <td>Rp {{ number_format($totalNoDeal, 0, ',', '.') }}</td>

            <th>Total Semua Report</th>
            <td>Rp {{ number_format($totalSemua, 0, ',', '.') }}</td>
        </tr>
    </table>
</div>

<table class="report-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Sales</th>
            <th>No SQ</th>
            <th>No PO</th>
            <th>Customer</th>
            <th>Description</th>
            <th>Qty</th>
            <th>Price/Unit</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @forelse($reports as $report)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $report->tanggal }}</td>
                <td>{{ $report->sales->name ?? '-' }}</td>
                <td>{{ $report->no_sq ?? '-' }}</td>
                <td>{{ $report->no_po ?? '-' }}</td>
                <td>{{ $report->customer_name }}</td>
                <td>{{ $report->description }}</td>
                <td class="text-center">{{ $report->qty }}</td>
                <td class="text-right">
                    Rp {{ number_format($report->price_unit, 0, ',', '.') }}
                </td>
                <td class="text-right">
                    Rp {{ number_format($report->total, 0, ',', '.') }}
                </td>
                <td class="text-center">
                    {{ strtoupper(str_replace('_', ' ', $report->status)) }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="11" class="text-center">
                    Data report belum ada.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<table class="ttd">
    <tr>
        <td>
            Dibuat Oleh,<br><br><br><br>
            ( __________________ )
        </td>

        <td>
            Admin,<br><br><br><br>
            ( __________________ )
        </td>

        <td>
            Manager,<br><br><br><br>
            ( __________________ )
        </td>
    </tr>
</table>

</body>
</html>