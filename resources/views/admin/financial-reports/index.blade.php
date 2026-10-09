
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Financial Reports — FixIT Admin</title>

    <link
        rel="icon"
        type="image/png"
        href="{{ asset('favicon.png') }}"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/style.css') }}"
    >
</head>

<body>

    {{-- ========================================
         Admin Navigation
         ======================================== --}}

    
<header class="nav">

    <div class="container">

        <a
            href="{{ route('admin.dashboard') }}"
            class="brand"
        >
            <span class="mark">FX</span>
            FixIT Admin
        </a>

        <nav class="nav-links" aria-label="Admin navigation">

            <a href="{{ route('admin.dashboard') }}">
                Dashboard
            </a>

            <a href="{{ route('admin.services.index') }}">
                Services
            </a>

            <a href="{{ route('admin.repairs.index') }}">
                Repairs
            </a>

            <a href="{{ route('admin.promos.index') }}">
                Promos
            </a>

            <a
                href="{{ route('admin.financial-reports') }}"
                class="active"
                aria-current="page"
            >
                Financial Reports
            </a>

        </nav>

        <div class="nav-actions">

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button
                    type="submit"
                    class="btn -secondary -sm"
                >
                    Log out
                </button>
            </form>

        </div>

    </div>

</header>

    {{-- ========================================
         Financial Reports
         ======================================== --}}

    <main class="admin-finance-page">

        <div class="container">


            {{-- Page Header --}}

            <section class="admin-finance-heading">

                <div>

                    <span class="section-tag">
                        ADMINISTRATION
                    </span>

                    <h1>
                        Financial Reports
                    </h1>

                    <p>
                        Monitor recorded payments, review transaction
                        history, and track FixIT's financial activity.
                    </p>

                </div>

                <span class="admin-finance-simulation-label">
                    SIMULATED PAYMENTS
                </span>

            </section>


            {{-- ========================================
                 Report Period Filter
                 ======================================== --}}

            <section
                class="admin-finance-panel"
                aria-labelledby="finance-period-title"
            >

                <div class="admin-finance-panel-heading">

                    <h2 id="finance-period-title">
                        Report Period
                    </h2>

                    <p>
                        Select a date range based on payment completion time.
                    </p>

                </div>

                <form
                    action="{{ route('admin.financial-reports') }}"
                    method="GET"
                    class="admin-finance-filter"
                >

                    {{-- Start Date --}}

                    <div class="admin-finance-field">

                        <label for="from">
                            From
                        </label>

                        <input
                            type="date"
                            id="from"
                            name="from"
                            value="{{ old('from', $fromDate) }}"
                            required
                        >

                        @error('from')
                            <span
                                class="admin-finance-error"
                                role="alert"
                            >
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- End Date --}}

                    <div class="admin-finance-field">

                        <label for="to">
                            To
                        </label>

                        <input
                            type="date"
                            id="to"
                            name="to"
                            value="{{ old('to', $toDate) }}"
                            required
                        >

                        @error('to')
                            <span
                                class="admin-finance-error"
                                role="alert"
                            >
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- Filter Actions --}}

                    <button
                        type="submit"
                        class="btn -primary"
                    >
                        Apply Filter
                    </button>

                    <a
                        href="{{ route('admin.financial-reports') }}"
                        class="btn -ghost"
                    >
                        This Month
                    </a>

                </form>

            </section>


            {{-- ========================================
                 Financial Summary
                 ======================================== --}}

            <section
                class="admin-finance-summary"
                aria-label="Financial summary"
            >

                {{-- Recorded Revenue --}}

                <article class="admin-finance-stat">

                    <span class="admin-finance-stat-label">
                        RECORDED REVENUE
                    </span>

                    <strong>
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </strong>

                    <p>
                        Successful payments in the selected period
                    </p>

                </article>


                {{-- Transaction Count --}}

                <article class="admin-finance-stat">

                    <span class="admin-finance-stat-label">
                        TRANSACTIONS
                    </span>

                    <strong>
                        {{ number_format($transactionCount, 0, ',', '.') }}
                    </strong>

                    <p>
                        Payments marked as paid
                    </p>

                </article>


                {{-- Average Transaction --}}

                <article class="admin-finance-stat">

                    <span class="admin-finance-stat-label">
                        AVERAGE TRANSACTION
                    </span>

                    <strong>
                        Rp {{ number_format($averageTransaction, 0, ',', '.') }}
                    </strong>

                    <p>
                        Average amount per successful payment
                    </p>

                </article>

            </section>


            {{-- ========================================
                 Revenue by Payment Method
                 ======================================== --}}

            <section
                class="admin-finance-panel"
                aria-labelledby="finance-method-title"
            >

                <div class="admin-finance-panel-heading">

                    <span class="section-tag">
                        PAYMENT ANALYSIS
                    </span>

                    <h2 id="finance-method-title">
                        Revenue by Payment Method
                    </h2>

                    <p>
                        Compare the total value and volume of successful
                        payments by payment method.
                    </p>

                </div>


                @if ($paymentBreakdown->isEmpty())

                    <div class="admin-finance-empty">

                        No successful payments were recorded during
                        the selected period.

                    </div>

                @else

                    <div class="admin-finance-table-wrap">

                        <table class="admin-finance-table">

                            <thead>
                                <tr>
                                    <th scope="col">
                                        Payment Method
                                    </th>

                                    <th scope="col">
                                        Transactions
                                    </th>

                                    <th
                                        scope="col"
                                        class="text-right"
                                    >
                                        Total Amount
                                    </th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($paymentBreakdown as $item)

                                    <tr>

                                        <td>
                                            <strong>
                                                {{ strtoupper($item->payment_method) }}
                                            </strong>
                                        </td>

                                        <td>
                                            {{ number_format($item->transaction_count, 0, ',', '.') }}
                                        </td>

                                        <td class="text-right">
                                            <strong>
                                                Rp {{ number_format($item->total_amount, 0, ',', '.') }}
                                            </strong>
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @endif

            </section>


            {{-- ========================================
                 Financial History
                 ======================================== --}}

            <section
                class="admin-finance-panel"
                aria-labelledby="finance-history-title"
            >

                <div class="admin-finance-panel-heading">

                    <span class="section-tag">
                        TRANSACTION RECORDS
                    </span>

                    <h2 id="finance-history-title">
                        Financial History
                    </h2>

                    <p>
                        Review individual payment records from newest
                        to oldest within the selected period.
                    </p>

                </div>


                @if ($transactions->isEmpty())

                    <div class="admin-finance-empty">

                        No transaction history was found for
                        the selected period.

                    </div>

                @else

                    <div class="admin-finance-table-wrap">

                        <table class="admin-finance-table">

                            <thead>

                                <tr>
                                    <th scope="col">
                                        Date
                                    </th>

                                    <th scope="col">
                                        Invoice
                                    </th>

                                    <th scope="col">
                                        Customer
                                    </th>

                                    <th scope="col">
                                        Method
                                    </th>

                                    <th scope="col">
                                        Status
                                    </th>

                                    <th
                                        scope="col"
                                        class="text-right"
                                    >
                                        Amount
                                    </th>
                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($transactions as $transaction)

                                    <tr>

                                        {{-- Payment Date --}}

                                        <td>
                                            {{ \Carbon\Carbon::parse($transaction->paid_at)->format('d M Y, H:i') }}
                                        </td>


                                        {{-- Invoice Number --}}

                                        <td>
                                            <strong>
                                                {{ $transaction->invoice_number }}
                                            </strong>
                                        </td>


                                        {{-- Customer Information --}}

                                        <td>

                                            <div class="admin-finance-customer">

                                                <strong>
                                                    {{ $transaction->customer_name }}
                                                </strong>

                                                <span>
                                                    {{ $transaction->customer_email }}
                                                </span>

                                            </div>

                                        </td>


                                        {{-- Payment Method --}}

                                        <td>
                                            {{ strtoupper($transaction->payment_method) }}
                                        </td>


                                        {{-- Payment Status --}}

                                        <td>

                                            <span class="admin-finance-status">
                                                {{ strtoupper($transaction->status) }}
                                            </span>

                                        </td>


                                        {{-- Payment Amount --}}

                                        <td class="text-right">
                                            <strong>
                                                Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                            </strong>
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    {{-- Pagination --}}

                    <div class="admin-finance-pagination">

                        {{ $transactions->links() }}

                    </div>

                @endif

            </section>


            {{-- ========================================
                 Financial Disclaimer
                 ======================================== --}}

            <footer class="admin-finance-disclaimer">

                <p>
                    SIMULATED PAYMENT DATA — This report reflects
                    payment records stored in FixIT. It does not
                    represent verified bank deposits or actual
                    cash received.
                </p>

            </footer>

        </div>

    </main>

</body>
</html>