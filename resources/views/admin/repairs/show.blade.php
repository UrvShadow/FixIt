<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Repair - Admin - FixIT</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <div class="container">

        <h1>Manage Repair</h1>

        @if (session('success'))
            <div>
                {{ session('success') }}
            </div>
        @endif

        <h2>Customer</h2>

        <p>
            <strong>Name:</strong>
            {{ $repair->user->name }}
        </p>

        <p>
            <strong>Email:</strong>
            {{ $repair->user->email }}
        </p>

        <p>
            <strong>Phone:</strong>
            {{ $repair->user->phone }}
        </p>

        <hr>

        <h2>Device</h2>

        <p>
            <strong>Name:</strong>
            {{ $repair->device->name }}
        </p>

        <p>
            <strong>Code:</strong>
            {{ $repair->device->device_code }}
        </p>

        <p>
            <strong>Category:</strong>
            {{ $repair->device->category }}
        </p>

        <p>
            <strong>Brand:</strong>
            {{ $repair->device->brand }}
        </p>

        <p>
            <strong>Model:</strong>
            {{ $repair->device->model ?? '-' }}
        </p>

        <hr>

        <h2>Reported Problem</h2>

        <p>
            {{ $repair->issue }}
        </p>

        <hr>

        <h2>Update Repair</h2>

        <form
            action="{{ route('admin.repairs.update-status', $repair) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div>
                <label for="status">
                    Status
                </label>

                <select
    id="status"
    name="status"
    required
>
    @php
        $allowedTransitions = [
            'pending' => ['confirmed', 'rejected', 'cancelled'],
            'confirmed' => ['diagnosing', 'rejected', 'cancelled'],
            'diagnosing' => ['repairing', 'rejected', 'cancelled'],
            'repairing' => ['waiting_payment', 'rejected', 'cancelled'],
            'waiting_payment' => ['paid', 'rejected', 'cancelled'],
            'paid' => ['completed'],
            'completed' => [],
            'rejected' => [],
            'cancelled' => [],
        ];

        $nextStatuses = $allowedTransitions[$repair->status] ?? [];
    @endphp

    <option value="{{ $repair->status }}" selected>
        {{ ucfirst(str_replace('_', ' ', $repair->status)) }}
    </option>

    @foreach ($nextStatuses as $status)
        <option value="{{ $status }}">
            {{ ucfirst(str_replace('_', ' ', $status)) }}
        </option>
    @endforeach
</select>
            </div>

            <br>

            <div>
                <label for="estimated_cost">
                    Estimated Cost
                </label>

                <input
                    type="number"
                    id="estimated_cost"
                    name="estimated_cost"
                    min="0"
                    step="0.01"
                    value="{{ old('estimated_cost', $repair->estimated_cost) }}"
                >
            </div>

            <br>

            <div>
                <label for="final_cost">
                    Final Cost
                </label>

                <input
                    type="number"
                    id="final_cost"
                    name="final_cost"
                    min="0"
                    step="0.01"
                    value="{{ old('final_cost', $repair->final_cost) }}"
                >
            </div>

            <br>

            <div>
                <label for="note">
                    Note
                </label>

                <textarea
                    id="note"
                    name="note"
                    rows="5"
                    placeholder="Add a note about this update..."
                >{{ old('note') }}</textarea>
            </div>

            <br>

            <button type="submit">
                Update Repair
            </button>

        </form>

        <hr>

        <h2>Repair History</h2>

        @forelse ($repair->repairHistories as $history)

            <div>

                <h3>
                    {{ ucfirst(str_replace('_', ' ', $history->status)) }}
                </h3>

                @if ($history->note)
                    <p>
                        {{ $history->note }}
                    </p>
                @endif

                <p>
                    {{ $history->created_at->format('d M Y H:i') }}
                </p>

                @if ($history->createdBy)
                    <small>
                        Updated by:
                        {{ $history->createdBy->name }}
                    </small>
                @endif

            </div>

            <hr>

        @empty

            <p>
                No repair history found.
            </p>

        @endforelse

        <a href="{{ route('admin.repairs.index') }}">
            ← Repair Requests
        </a>
        @if ($repair->final_cost !== null && ! $repair->invoice)
    <form action="{{ route('admin.repairs.create-invoice', $repair) }}" method="POST">
        @csrf

        <button type="submit">
            Generate Invoice
        </button>
    </form>
@elseif ($repair->invoice)
    <p>Invoice sudah dibuat: {{ $repair->invoice->invoice_number }}</p>
@endif

    </div>

</body>
</html>