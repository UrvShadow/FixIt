<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit {{ $promo->code }} — FixIT</title>

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
                            Edit Promo
                        </h1>

                        <p>
                            Update the promotional code and discount
                            configuration.
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
                                action="{{ route('admin.promos.update', $promo) }}"
                                method="POST"
                                class="admin-promo-form-fields"
                            >

                                @csrf
                                @method('PUT')

                                <div class="admin-promo-field">

                                    <label for="code">
                                        PROMO CODE
                                    </label>

                                    <input
                                        type="text"
                                        id="code"
                                        name="code"
                                        value="{{ old('code', $promo->code) }}"
                                        maxlength="50"
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
                                                {{ old('discount_type', $promo->discount_type) === 'percentage' ? 'selected' : '' }}
                                            >
                                                Percentage (%)
                                            </option>

                                            <option
                                                value="fixed"
                                                {{ old('discount_type', $promo->discount_type) === 'fixed' ? 'selected' : '' }}
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
                                            value="{{ old('discount_value', $promo->discount_value) }}"
                                            min="0"
                                            step="0.01"
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
                                        value="{{ old('minimum_transaction', $promo->minimum_transaction) }}"
                                        min="0"
                                        step="0.01"
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
                                        value="{{ old(
                                            'expires_at',
                                            $promo->expires_at
                                                ? $promo->expires_at->format('Y-m-d\TH:i')
                                                : ''
                                        ) }}"
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
                                            {{ old('is_active', $promo->is_active) ? 'checked' : '' }}
                                        >

                                        <span>

                                            <strong>
                                                Keep this promo active
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
                                        Save Changes
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
                                    {{ old('code', $promo->code) }}
                                </strong>

                            </div>

                            <div class="admin-promo-preview-discount">

                                <strong id="promo-preview-value">

                                    @if ($promo->discount_type === 'percentage')

                                        {{ rtrim(rtrim(number_format($promo->discount_value, 2, ',', '.'), '0'), ',') }}%

                                    @else

                                        Rp {{ number_format($promo->discount_value, 0, ',', '.') }}

                                    @endif

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
                                        Rp {{ number_format($promo->minimum_transaction, 0, ',', '.') }}
                                    </strong>

                                </div>

                                <div>

                                    <span>
                                        EXPIRES
                                    </span>

                                    <strong id="promo-preview-expiry">

                                        @if ($promo->expires_at)

                                            {{ $promo->expires_at->format('d M Y H:i') }}

                                        @else

                                            No expiration

                                        @endif

                                    </strong>

                                </div>

                            </div>

                            <p>
                                Changes will apply to future promo usage.
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
                code || 'PROMO';

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