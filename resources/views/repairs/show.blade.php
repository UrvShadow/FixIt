<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Repair Details - FixIT</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <div class="container">

        <h1>Repair Details</h1>

        <h2>{{ $repair->device->name }}</h2>

        <p>
            <strong>Device Code:</strong>
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

        @if ($repair->device->model)
            <p>
                <strong>Model:</strong>
                {{ $repair->device->model }}
            </p>
        @endif

        <hr>

        <h2>Reported Problem</h2>

        <p>
            {{ $repair->issue }}
        </p>

        <hr>

        <h2>Current Status</h2>

        <p>
            <strong>
                {{ ucfirst(str_replace('_', ' ', $repair->status)) }}
            </strong>
        </p>

        @if ($repair->estimated_cost)
            <p>
                <strong>Estimated Cost:</strong>
                Rp {{ number_format($repair->estimated_cost, 0, ',', '.') }}
            </p>
        @endif

        @if ($repair->final_cost)
            <p>
                <strong>Final Cost:</strong>
                Rp {{ number_format($repair->final_cost, 0, ',', '.') }}
            </p>
        @endif

        <hr>

        <h2>Repair Timeline</h2>

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
                No repair history available.
            </p>

        @endforelse

        <a href="{{ route('repairs.index') }}">
            ← My Repair Requests
        </a>
        @if ($repair->invoice)
    <div>
        <h3>Invoice</h3>

        <p>
            Invoice Number:
            {{ $repair->invoice->invoice_number }}
        </p>

        <p>
            Total:
            Rp {{ number_format($repair->invoice->total_amount, 0, ',', '.') }}
        </p>

        <p>
            Status:
            {{ ucfirst($repair->invoice->status) }}
        </p>

        @if ($repair->invoice->status !== 'paid')
            <hr>

            <h4>Pay Invoice</h4>

            @if ($errors->has('payment'))
                <p style="color: red;">
                    {{ $errors->first('payment') }}
                </p>
            @endif

            @if (session('success'))
                <p style="color: green;">
                    {{ session('success') }}
                </p>
            @endif

            <form
                action="{{ route('payments.store', $repair->invoice) }}"
                method="POST"
            >
                @csrf

                <label for="payment_method">
                    Payment Method
                </label>

                <select
                    name="payment_method"
                    id="payment_method"
                    required
                >
                    <option value="">-- Select Payment Method --</option>
                    <option value="cash">Cash</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="e_wallet">E-Wallet</option>
                </select>

                <button type="submit">
                    Pay Invoice
                </button>
            </form>
        @else
            <p>
                Payment sudah diterima.
            </p>
        @endif
    </div>
@endif
    </div>

</body>
</html>