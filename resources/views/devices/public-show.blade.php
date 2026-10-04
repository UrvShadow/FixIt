<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Device {{ $device->device_code }} - FixIT</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

<div class="container">

    <h1>Device Information</h1>

    <p>
        <strong>Device Code:</strong>
        {{ $device->device_code }}
    </p>

    <p>
        <strong>Name:</strong>
        {{ $device->name }}
    </p>

    <p>
        <strong>Category:</strong>
        {{ $device->category }}
    </p>

    <p>
        <strong>Brand:</strong>
        {{ $device->brand }}
    </p>

    <p>
        <strong>Model:</strong>
        {{ $device->model ?? '-' }}
    </p>

    <p>
        <strong>Serial Number:</strong>
        {{ $device->serial_number ?? '-' }}
    </p>

    @if ($device->description)
        <p>
            <strong>Description:</strong>
            {{ $device->description }}
        </p>
    @endif

    <hr>

    <h2>Repair History</h2>

    @forelse ($device->repairRequests as $repair)

        <div>
            <h3>
                Repair #{{ $repair->id }}
            </h3>

            <p>
                <strong>Issue:</strong>
                {{ $repair->issue }}
            </p>

            <p>
                <strong>Status:</strong>
                {{ ucfirst(str_replace('_', ' ', $repair->status)) }}
            </p>

            @if ($repair->repairHistories->count())
                <h4>History</h4>

                @foreach ($repair->repairHistories as $history)
                    <p>
                        {{ ucfirst(str_replace('_', ' ', $history->status)) }}
                        —
                        {{ $history->created_at->format('d M Y H:i') }}
                    </p>
                @endforeach
            @endif
        </div>

        <hr>

    @empty

        <p>No repair history found.</p>

    @endforelse

</div>

</body>
</html>