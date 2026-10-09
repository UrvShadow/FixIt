<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Log in — FixIT</title>

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

    <div class="auth-shell">

        <div class="auth-visual">

            <a
                href="{{ route('home') }}"
                class="brand"
            >
                <span class="mark">FX</span>FixIT
            </a>

            <div class="ticket">

                <div class="ticket-top">

                    <div>
                        <div class="label">
                            Repair
                        </div>

                        <div class="value">
                            #FX-2026-014
                        </div>
                    </div>

                    <span class="stamp -done">
                        <span class="dot"></span>
                        Completed
                    </span>

                </div>

                <div class="ticket-device">
                    iPhone 13 — Battery replacement
                </div>

                <div class="ticket-issue">
                    Battery health at 61%, rapid drain
                </div>

                <div class="ticket-steps">

                    <div class="tstep -done">
                        <div class="node"></div>
                        <span>Request submitted</span>
                    </div>

                    <div class="tstep -done">
                        <div class="node"></div>
                        <span>Repair completed</span>
                    </div>

                    <div class="tstep -done">
                        <div class="node"></div>
                        <span>Payment completed</span>
                    </div>

                </div>

            </div>

            <div class="auth-visual-copy">

                <h2>
                    Welcome back.
                </h2>

                <p>
                    Log in to manage your active repairs,
                    review past requests, and track progress.
                </p>

            </div>

        </div>


        <div class="auth-form-side">

            <div class="auth-box">

                <a
                    href="{{ route('home') }}"
                    class="brand"
                >
                    <span class="mark">FX</span>FixIT
                </a>

                <h1>
                    Welcome back!
                </h1>

                <p>
                    Log in to manage and track your repair requests.
                </p>


                @if ($errors->any())

                    <div class="form-note auth-error">
                        {{ $errors->first() }}
                    </div>

                @endif


                <form
                    action="{{ route('login') }}"
                    method="POST"
                >
                    @csrf

                    <div class="field">

                        <label for="email">
                            Email
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="you@email.com"
                            value="{{ old('email') }}"
                            required
                        >

                    </div>


                    <div class="field">

                        <label for="password">
                            Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            required
                        >

                    </div>


                    <button
                        type="submit"
                        class="btn -primary -block"
                    >
                        Log in
                    </button>

                </form>


                <p class="auth-switch">
                    Don't have an account?
                    <a href="{{ route('register') }}">
                        Register
                    </a>
                </p>

            </div>

        </div>

    </div>


    <script src="{{ asset('js/script.js') }}"></script>

</body>

</html>