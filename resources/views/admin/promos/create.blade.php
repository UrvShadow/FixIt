<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Add Promo — FixIT</title>

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

    <header class="nav">

        <div class="container">

            <a
                href="{{ route('home') }}"
                class="brand"
            >
                <span class="mark">FX</span>FixIT
            </a>

            <nav class="nav-links">

                <a href="{{ route('admin.dashboard') }}">
                    Dashboard
                </a>

                <a href="{{ route('admin.services.index') }}">
                    Services
                </a>

                <a href="{{ route('admin.repairs.index') }}">
                    Repairs
                </a>

                <a
                    href="{{ route('admin.promos.index') }}"
                    class="active"
                >
                    Promos
                </a>

            </nav>

            <div class="nav-actions">

                <form
                    action="{{ route('logout') }}"
                    method="POST"
                >
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

    <main>

        <section class="admin-promo-form">

            <div class="container">

                <div class="admin-promo-form-back">

                    <a
                        href="{{ route('admin.promos.index') }}"
                        class="btn -ghost -sm"
                    >
                        ← Promo Management
                    </a>

                </div>

                <div class="admin-promo-form-head">

                    <div>

                        <div class="section-tag">
                            ADMINISTRATION
                        </div>

                        <h1>
                            Add Promo
                        </h1>

                        <p>
                            Create a promotional code that customers can
                            apply during payment.
                        </p>

                    </div>

                </div>

                @if ($errors->any())

                    <div class="admin-promo-errors">

                        <strong>
                            Please fix the following:
                        </strong>

                        <ul>

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif

                <div class="admin-promo-form-layout">

                    <div class="admin-promo-form-main">

                        <article class="admin-promo-form-card">

                            <div class="section-tag">
                                PROMO DETAILS
                            </div>

                            <h2>
                                Discount Configuration
                            </h2>

                            <form
                                action="{{ route('admin.promos.store') }}"
                                method="POST"
                                class="admin-promo-form-fields"
                            >

                                @csrf

                                <div class="admin-promo-field">

                                    <label for="code">
                                        PROMO CODE
                                    </label>

                                    <input
                                        type="text"
                                        id="code"
                                        name="code"
                                        value="{{ old('code') }}"
                                        maxlength="50"
                                        placeholder="WELCOME10"
                                        required
                                    >

                                    <small>
                                        Customers will enter this code during payment.
                                    </small>

                                </div>

                                <div class="admin-promo-field-grid">

                                    <div class="admin-promo-field">

                                        <label for="discount_type">
                                            DISCOUNT TYPE
                                        </label>

                                        <select
                                            id="discount_type"
                                            name="discount_type"
                                            required
                                        >

                                            <option
                                                value="percentage"
                                                {{ old('discount_type', 'percentage') === 'percentage' ? 'selected' : '' }}
                                            >
                                                Percentage (%)
                                            </option>

                                            <option
                                                value="fixed"
                                                {{ old('discount_type') === 'fixed' ? 'selected' : '' }}
                                            >
                                                Fixed Amount (Rp)
                                            </option>

                                        </select>

                                    </div>

                                    <div class="admin-promo-field">

                                        <label for="discount_value">
                                            DISCOUNT VALUE
                                        </label>

                                        <input
                                            type="number"
                                            id="discount_value"
                                            name="discount_value"
                                            value="{{ old('discount_value') }}"
                                            min="0"
                                            step="0.01"
                                            placeholder="10"
                                            required
                                        >

                                    </div>

                                </div>

                                <div class="admin-promo-field">

                                    <label for="minimum_transaction">
                                        MINIMUM TRANSACTION
                                    </label>

                                    <input
                                        type="number"
                                        id="minimum_transaction"
                                        name="minimum_transaction"
                                        value="{{ old('minimum_transaction', 0) }}"
                                        min="0"
                                        step="0.01"
                                        placeholder="100000"
                                        required
                                    >

                                    <small>
                                        Set 0 if there is no minimum transaction requirement.
                                    </small>

                                </div>

                                <div class="admin-promo-field">

                                    <label for="expires_at">
                                        EXPIRATION
                                    </label>

                                    <input
                                        type="datetime-local"
                                        id="expires_at"
                                        name="expires_at"
                                        value="{{ old('expires_at') }}"
                                    >

                                    <small>
                                        Leave empty if this promo does not expire.
                                    </small>

                                </div>

                                <div class="admin-promo-active">

                                    <label class="admin-promo-checkbox">

                                        <input
                                            type="checkbox"
                                            name="is_active"
                                            value="1"
                                            {{ old('is_active', true) ? 'checked' : '' }}
                                        >

                                        <span>
                                            <strong>
                                                Activate this promo
                                            </strong>

                                            <small>
                                                Customers can use this promo immediately.
                                            </small>
                                        </span>

                                    </label>

                                </div>

                                <div class="admin-promo-form-actions">

                                    <a
                                        href="{{ route('admin.promos.index') }}"
                                        class="btn -secondary"
                                    >
                                        Cancel
                                    </a>

                                    <button
                                        type="submit"
                                        class="btn -primary"
                                    >
                                        Create Promo
                                    </button>

                                </div>

                            </form>

                        </article>

                    </div>

                    <aside class="admin-promo-form-side">

                        <article class="admin-promo-preview">

                            <div class="section-tag">
                                PREVIEW
                            </div>

                            <div class="admin-promo-preview-code">
                                <span>
                                    PROMO CODE
                                </span>

                                <strong id="promo-preview-code">
                                    {{ old('code', 'WELCOME10') }}
                                </strong>
                            </div>

                            <div class="admin-promo-preview-discount">

                                <strong id="promo-preview-value">
                                    10%
                                </strong>

                                <span>
                                    DISCOUNT
                                </span>

                            </div>

                            <div class="admin-promo-preview-info">

                                <div>

                                    <span>
                                        MINIMUM
                                    </span>

                                    <strong id="promo-preview-minimum">
                                        Rp 0
                                    </strong>

                                </div>

                                <div>

                                    <span>
                                        EXPIRES
                                    </span>

                                    <strong id="promo-preview-expiry">
                                        No expiration
                                    </strong>

                                </div>

                            </div>

                            <p>
                                This preview shows how the promo will be
                                represented in the admin panel.
                            </p>

                        </article>

                    </aside>

                </div>

            </div>

        </section>

    </main>

    <script>
        const codeInput = document.getElementById('code');
        const typeInput = document.getElementById('discount_type');
        const valueInput = document.getElementById('discount_value');
        const minimumInput = document.getElementById('minimum_transaction');
        const expiryInput = document.getElementById('expires_at');

        const previewCode =
            document.getElementById('promo-preview-code');

        const previewValue =
            document.getElementById('promo-preview-value');

        const previewMinimum =
            document.getElementById('promo-preview-minimum');

        const previewExpiry =
            document.getElementById('promo-preview-expiry');

        function formatRupiah(value) {
            const number = Number(value);

            if (!Number.isFinite(number)) {
                return 'Rp 0';
            }

            return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
        }

        function updatePreview() {
            const code =
                codeInput.value.trim().toUpperCase();

            const type =
                typeInput.value;

            const value =
                Number(valueInput.value);

            const minimum =
                Number(minimumInput.value);

            previewCode.textContent =
                code || 'WELCOME10';

            if (type === 'percentage') {

                previewValue.textContent =
                    `${Number.isFinite(value) ? value : 0}%`;

            } else {

                previewValue.textContent =
                    formatRupiah(value);

            }

            previewMinimum.textContent =
                formatRupiah(minimum);

            if (expiryInput.value) {

                const date =
                    new Date(expiryInput.value);

                if (!Number.isNaN(date.getTime())) {

                    previewExpiry.textContent =
                        date.toLocaleString('id-ID', {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });

                }

            } else {

                previewExpiry.textContent =
                    'No expiration';

            }
        }

        [
            codeInput,
            typeInput,
            valueInput,
            minimumInput,
            expiryInput
        ].forEach((input) => {

            input.addEventListener(
                'input',
                updatePreview
            );

            input.addEventListener(
                'change',
                updatePreview
            );

        });

        updatePreview();
    </script>

</body>

</html>