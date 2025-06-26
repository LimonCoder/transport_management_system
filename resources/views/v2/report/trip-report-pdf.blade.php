<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ __('message.trip_report_title') }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        .info {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        thead {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

    <h2>{{ __('message.trip_report_title') }}</h2>

    <div class="info">
        @if($filters['month'])
            <p><strong>Month:</strong> {{ $filters['month'] }}</p>
        @endif
        @if($filters['start_date'] && $filters['end_date'])
            <p><strong>Date Range:</strong> {{ $filters['start_date'] }} - {{ $filters['end_date'] }}</p>
        @endif
        @if($filters['driver_id'])
            <p><strong>Driver:</strong> {{ $trips->first()->driver_name ?? '-' }}</p>
        @endif
        @if($filters['route_id'])
            <p><strong>Route:</strong> {{ $trips->first()->route_name ?? '-' }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Trip Date</th>
                <th>Route</th>
                <th>Driver</th>
                <th>Vehicle</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trips as $i => $trip)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $trip->trip_initiate_date }}</td>
                    <td>{{ $trip->route_name }}</td>
                    <td>{{ $trip->driver_name }}</td>
                    <td>{{ $trip->vehicle_registration_number }}</td>
                    <td>{{ $trip->status ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
