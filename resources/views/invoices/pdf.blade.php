<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>
        Invoice {{ $invoice->invoice_number }}
    </title>

    <style>

        @page {
            margin: 40px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;

            color: #222222;

            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;

            line-height: 1.5;
        }


        /* ========================================
           Header
           ======================================== */

        .header {
            display: table;

            width: 100%;

            margin-bottom: 32px;

            padding-bottom: 20px;

            border-bottom: 2px solid #222222;
        }

        .header-left,
        .header-right {
            display: table-cell;

            vertical-align: top;
        }

        .header-right {
            width: 40%;

            text-align: right;
        }

        .brand {
            margin: 0;

            font-size: 24px;
            font-weight: bold;
        }

        .brand-mark {
            display: inline-block;

            margin-right: 6px;

            font-size: 13px;
            font-weight: bold;
        }

        .document-title {
            margin: 0 0 4px;

            font-size: 22px;
            font-weight: bold;
        }

        .invoice-number {
            margin: 0;

            color: #666666;

            font-size: 10px;
        }


        /* ========================================
           Invoice Meta
           ======================================== */

        .meta {
            display: table;

            width: 100%;

            margin-bottom: 28px;
        }

        .meta-column {
            display: table-cell;

            width: 50%;

            vertical-align: top;
        }

        .meta-column:last-child {
            text-align: right;
        }

        .meta-label {
            margin-bottom: 4px;

            color: #888888;

            font-size: 9px;
            font-weight: bold;

            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .meta-value {
            margin: 0;

            font-size: 12px;
        }


        /* ========================================
           Section
           ======================================== */

        .section {
            margin-bottom: 24px;
        }

        .section-title {
            margin: 0 0 10px;

            font-size: 11px;
            font-weight: bold;

            text-transform: uppercase;
        }


        /* ========================================
           Details Table
           ======================================== */

        table {
            width: 100%;

            border-collapse: collapse;
        }

        th {
            padding: 9px 10px;

            background: #eeeeee;

            border: 1px solid #dddddd;

            font-size: 9px;

            text-align: left;

            text-transform: uppercase;
        }

        td {
            padding: 10px;

            border: 1px solid #dddddd;

            vertical-align: top;
        }


        /* ========================================
           Amount
           ======================================== */

        .amount-section {
            margin-top: 20px;

            text-align: right;
        }

        .amount-label {
            margin-bottom: 4px;

            color: #777777;

            font-size: 10px;
        }

        .amount {
            font-size: 20px;
            font-weight: bold;
        }


        /* ========================================
           Payment
           ======================================== */

        .payment-box {
            margin-top: 24px;

            padding: 14px;

            background: #f5f5f5;

            border: 1px solid #dddddd;
        }

        .payment-row {
            display: table;

            width: 100%;

            margin-bottom: 5px;
        }

        .payment-row:last-child {
            margin-bottom: 0;
        }

        .payment-label,
        .payment-value {
            display: table-cell;
        }

        .payment-value {
            text-align: right;
            font-weight: bold;
        }

        .paid {
            color: #278a4b;
        }

        .unpaid {
            color: #b42318;
        }


        /* ========================================
           Footer
           ======================================== */

        .footer {
            position: fixed;

            bottom: -15px;
            left: 0;
            right: 0;

            color: #888888;

            font-size: 9px;

            text-align: center;
        }

    </style>

</head>

<body>


    {{-- ========================================
         Header
         ======================================== --}}

    <div class="header">

        <div class="header-left">

            <h1 class="brand">
                <span class="brand-mark">FX</span>
                FixIT
            </h1>

            <p class="invoice-number">
                Repair & Device Management System
            </p>

        </div>

        <div class="header-right">

            <h2 class="document-title">
                INVOICE
            </h2>

            <p class="invoice-number">
                {{ $invoice->invoice_number }}
            </p>

        </div>

    </div>


    {{-- ========================================
         Customer / Invoice Information
         ======================================== --}}

    <div class="meta">

        <div class="meta-column">

            <div class="meta-label">
                Customer
            </div>

            <p class="meta-value">
                {{ $invoice->repairRequest->user->name }}
            </p>

        </div>


        <div class="meta-column">

            <div class="meta-label">
                Issued At
            </div>

            <p class="meta-value">
                {{ optional($invoice->issued_at)->format('d M Y, H:i') ?? '-' }}
            </p>

        </div>

    </div>


    {{-- ========================================
         Repair Information
         ======================================== --}}

    <div class="section">

        <h3 class="section-title">
            Repair Information
        </h3>

        <table>

            <thead>

                <tr>
                    <th>
                        Repair
                    </th>

                    <th>
                        Device
                    </th>

                    <th>
                        Device Code
                    </th>

                    <th>
                        Status
                    </th>
                </tr>

            </thead>

            <tbody>

                <tr>

                    <td>
                        #{{ $invoice->repairRequest->id }}
                    </td>

                    <td>
                        {{ $invoice->repairRequest->device->name }}
                    </td>

                    <td>
                        {{ $invoice->repairRequest->device->device_code }}
                    </td>

                    <td>
                        {{ ucfirst(str_replace('_', ' ', $invoice->repairRequest->status)) }}
                    </td>

                </tr>

            </tbody>

        </table>

    </div>


    {{-- ========================================
         Problem
         ======================================== --}}

    <div class="section">

        <h3 class="section-title">
            Reported Problem
        </h3>

        <table>

            <tr>

                <td>
                    {{ $invoice->repairRequest->issue }}
                </td>

            </tr>

        </table>

    </div>


    {{-- ========================================
         Payment
         ======================================== --}}

    <div class="payment-box">

        @php
            $payment = $invoice->payments
                ->where('status', 'paid')
                ->sortByDesc('paid_at')
                ->first();
        @endphp


        <div class="payment-row">

            <span class="payment-label">
                Payment Status
            </span>

            <span class="payment-value {{ $invoice->status === 'paid' ? 'paid' : 'unpaid' }}">
                {{ strtoupper($invoice->status) }}
            </span>

        </div>


        @if ($payment)

            <div class="payment-row">

                <span class="payment-label">
                    Payment Method
                </span>

                <span class="payment-value">
                    @if ($payment->payment_method === 'qris')
                        QRIS
                    @elseif ($payment->payment_method === 'bca')
                        BCA Bank Transfer
                    @elseif ($payment->payment_method === 'mandiri')
                        Mandiri Bank Transfer
                    @elseif ($payment->payment_method === 'bni')
                        BNI Bank Transfer
                    @else
                        {{ strtoupper($payment->payment_method) }}
                    @endif
                </span>

            </div>


            <div class="payment-row">

                <span class="payment-label">
                    Paid At
                </span>

                <span class="payment-value">
                    {{ optional($payment->paid_at)->format('d M Y, H:i') ?? '-' }}
                </span>

            </div>

        @endif

    </div>


    {{-- ========================================
         Total
         ======================================== --}}

    <div class="amount-section">

        <div class="amount-label">
            Total Amount
        </div>

        <div class="amount">
            Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}
        </div>

    </div>


    {{-- ========================================
         Footer
         ======================================== --}}

    <div class="footer">
        This invoice was generated by FixIT.
        This document is valid as a system-generated invoice.
    </div>


</body>

</html>