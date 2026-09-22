<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Repairs - FixIT</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <div class="container">

        <h1>My Repair Requests</h1>

        @if (session('success'))
            <div>
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('repairs.create') }}">
            + Request Repair
        </a>

        <hr>

        @forelse ($repairRequests as $repair)
        
        
            <div>

                <h2>
                    {{ $repair->device->name }}
                </h2>

                <p>
                    Device Code:
                    {{ $repair->device->device_code }}
                </p>

                <p>
                    Issue:
                    {{ $repair->issue }}
                </p>

                <p>
                    Status:
                    <strong>{{ ucfirst($repair->status) }}</strong>
                </p>

                <a href="{{ route('repairs.show', $repair) }}">
                    View Details
                </a>

                @if ($repair->estimated_cost)
                    <p>
                        Estimated Cost:
                        Rp {{ number_format($repair->estimated_cost, 0, ',', '.') }}
                    </p>
                @endif

                @if ($repair->final_cost)
                    <p>
                        Final Cost:
                        Rp {{ number_format($repair->final_cost, 0, ',', '.') }}
                    </p>
                @endif

                <p>
                    Submitted:
                    {{ $repair->created_at->format('d M Y H:i') }}
                </p>

            </div>

            <hr>

        @empty

            <p>
                You don't have any repair requests yet.
            </p>

        @endforelse

        <a href="{{ route('dashboard') }}">
            ← Dashboard
        </a>

    </div>

</body>
</html>