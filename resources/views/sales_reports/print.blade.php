<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Print Sales Report</title>
    <style>
    @page {
        size: A4;
        margin: 15mm;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        color: #000;
        margin: 0;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .header h2 {
        margin: 0 0 8px 0;
        font-size: 22px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        width: 220px;
        text-align: left;
        background: #f2f2f2;
    }

    th, td {
        border: 1px solid #000;
        padding: 8px 10px;
    }

    .ttd {
        margin-top: 70px;
        width: 100%;
    }

    .ttd td {
        border: none;
        text-align: center;
        height: 110px;
        vertical-align: bottom;
    }

    .no-print {
        margin-bottom: 20px;
    }

    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>
</head>
<body>

<div class="no-print" style="margin-bottom:20px;">
    <button onclick="window.print()">Cetak PDF</button>
</div>

<div class="header">
    <h2>SALES REPORT</h2>
    <p>PT Dynagear Pandu Pratama</p>
</div>

<table>
    <tr>
        <th>Sales</th>
        <td>{{ $salesReport->sales->name ?? '-' }}</td>
    </tr>
    <tr>
        <th>Tanggal</th>
        <td>{{ $salesReport->tanggal }}</td>
    </tr>
    <tr>
        <th>No SQ</th>
        <td>{{ $salesReport->no_sq ?? '-' }}</td>
    </tr>
    <tr>
        <th>No PO</th>
        <td>{{ $salesReport->no_po ?? '-' }}</td>
    </tr>
    <tr>
        <th>Customer</th>
        <td>{{ $salesReport->customer_name }}</td>
    </tr>
    <tr>
        <th>Description</th>
        <td>{{ $salesReport->description }}</td>
    </tr>
    <tr>
        <th>Qty</th>
        <td>{{ $salesReport->qty }}</td>
    </tr>
    <tr>
        <th>Price Unit</th>
        <td>Rp {{ number_format($salesReport->price_unit, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Total</th>
        <td>Rp {{ number_format($salesReport->total, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Status</th>
        <td>{{ strtoupper(str_replace('_', ' ', $salesReport->status)) }}</td>
    </tr>
    <tr>
        <th>Follow Up</th>
        <td>{{ $salesReport->next_followup_date ?? '-' }}</td>
    </tr>
    <tr>
        <th>Komentar Sales</th>
        <td>{{ $salesReport->sales_comment ?? '-' }}</td>
    </tr>
</table>

<table class="ttd">
    <tr>
        <td>
            Dibuat Oleh,<br><br><br><br>
            ( {{ $salesReport->sales->name ?? 'Sales' }} )
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

<script>
    window.onload = function () {
        window.print();
    }
</script>

</body>
</html>