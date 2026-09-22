<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Repair Requests - Admin - FixIT</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <div class="container">

        <h1>Repair Requests</h1>

        @forelse ($repairRequests as $repair)

            <div>

                <h2>
                    {{ $repair->device->name }}
                </h2>

                <p>
                    Customer:
                    {{ $repair->user->name }}
                </p>

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
                    <strong>
                        {{ ucfirst(str_replace('_', ' ', $repair->status)) }}
                    </strong>
                </p>

                <a href="{{ route('admin.repairs.show', $repair) }}">
                    View & Manage
                </a>

            </div>

            <hr>

        @empty

            <p>
                No repair requests found.
            </p>

        @endforelse

        <a href="{{ route('admin.dashboard') }}">
            ← Admin Dashboard
        </a>

    </div>

</body>
</html>