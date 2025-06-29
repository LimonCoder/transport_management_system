<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ __('message.trip_report_title') }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Helvetica, sans-serif;
            /* DomPDF compatible font */
            font-size: 12px;
            line-height: 1.4;
            color: #000;
        }

        @page {
            margin: 5px;
            size: A4;
        }

        h2 {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .info {
            text-align: center;
            margin-bottom: 12px;
            font-weight: 500;
            font-size: 13px;
        }

        .report-table {
            width: 98%;
            margin: auto;
            border-collapse: collapse;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #000;
            padding: 3px;
            font-size: 12px;
            text-align: center;
            vertical-align: middle;
        }

        .report-table thead th {
            background-color: #f2f2f2;
        }

        .footer-total {
            font-weight: bold;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>

    <h2>{{ __('message.trip_report_title') }}</h2>

    <div class="info">
        @if($filters['route_id'])
        <div><strong>Route:</strong> {{ $routeName ?? '-' }}</div>
        @endif

        @if($filters['driver_id'])
        <div><strong>Driver:</strong> {{ $driverName ?? '-' }}</div>
        @endif

        @if($filters['month'])
        @php
        $timezone = 'Asia/Dhaka'; // You can also use config('app.timezone')
        $monthFormatted = \Carbon\Carbon::createFromFormat('Y-m', $filters['month'], $timezone)
        ->timezone($timezone)
        ->format('F - Y');
        @endphp
        <div><strong>Month:</strong> {{ $monthFormatted }}</div>
        @endif

        @if($filters['start_date'] && $filters['end_date'])
        <div><strong>Date Range:</strong> {{ $filters['start_date'] }} To {{ $filters['end_date'] }}</div>
        @endif
        <div><strong>Generated on:</strong> {{ now()->format('d-m-Y h:i:s A') }}</div>
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th>Sl</th>
                <th>Trip Date</th>
                <th>Route</th>
                <th>Driver</th>
                <th>Vehicle</th>
                <th>Distance (km)</th>
                <th>Total Cost</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trips as $i => $trip)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($trip->trip_initiate_date)->format('d-m-Y') }}</td>
                <td>{{ $trip->route_name }}</td>
                <td>{{ $trip->driver_name }}</td>
                <td>{{ $trip->vehicle_registration_number }}</td>
                <td>{{ $trip->distance_km ?? '-' }}</td>
                <td>{{ number_format($trip->total_cost ?? 0, 2) }}</td>
                <td>{{ ucfirst($trip->status ?? '-') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="footer-total">
                <td colspan="5" class="text-right"><strong>Total</strong></td>
                <td><strong>{{ number_format($total_distance_km, 2) }}</strong></td>
                <td><strong>{{ number_format($total_cost, 2) }}</strong></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

</body>

</html>