<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1, h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .nested-table {
            margin-top: 10px;
        }

        .nested-table table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
        }

        .nested-table table, .nested-table th, .nested-table td {
            border: 1px solid #ddd;
        }

        .nested-table th {
            background-color: #e6e6e6;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

    <h1>All Invoices</h1>

    <!-- Loop through each invoice -->
    @foreach ($invoices as $invoice)
        <h2>Invoice #{{ $invoice->id }} - {{ $invoice->tenant->firstName }}</h2>

        <!-- Main Invoice Table -->
        <table>
            <tr>
                <th>Recipient</th>
                <td>{{ $invoice->tenant->firstName }}</td>
                <th>Invoice Date</th>
                <td>{{ DateTime::createFromFormat('!m', $invoice->invoice_month)->format('M') . ' - ' . $invoice->invoice_year }}</td>
            </tr>
            <tr>
                <th>Unit</th>
                <td>{{ $invoice->unit->name }}</td>
                <th>Total Amount</th>
                <td>{{ number_format($invoice->amount, 2) }}</td>
            </tr>
        </table>

        <!-- Nested Items Table (inside the main table) -->
        <div class="nested-table">
            <h3>Items</h3>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th class="right">Amount</th>\
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through each item in the current invoice -->
                    @foreach ($invoice->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->description }}</td>
                            <td class="right">{{ number_format($item->amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Page Break after each invoice -->
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach

</body>
</html>
