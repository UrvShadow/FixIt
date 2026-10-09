<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Create account — FixIT</title>

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
                            #FX-2026-021
                        </div>
                    </div>

                    <span class="stamp -pending">
                        <span class="dot"></span>
                        Awaiting confirmation
                    </span>

                </div>


                <div class="ticket-device">
                    Samsung Washing Machine
                </div>

                <div class="ticket-issue">
                    Not draining, loud noise on spin cycle
                </div>


                <div class="ticket-steps">

                    <div class="tstep -done">
                        <div class="node"></div>
                        <span>Request submitted</span>
                    </div>

                    <div class="tstep -active">
                        <div class="node"></div>
                        <span>Request confirmed</span>
                    </div>

                    <div class="tstep -todo">
                        <div class="node"></div>
                        <span>Diagnosis</span>
                    </div>

                </div>

            </div>


            <div class="auth-visual-copy">

                <h2>
                    Get your first repair sorted.
                </h2>

                <p>
                    Create an account to submit requests,
                    track progress, and keep a record of every repair.
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
                    Create your account
                </h1>

                <p>
                    Start submitting and tracking repair requests in minutes.
                </p>


                @if ($errors->any())

                    <div class="form-note auth-error">
                        {{ $errors->first() }}
                    </div>

                @endif


                <form
                    action="{{ route('register') }}"
                    method="POST"
                >
                    @csrf


                    <div class="field">

                        <label for="name">
                            Full name
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            placeholder="Jordan Rivera"
                            value="{{ old('name') }}"
                            required
                        >

                    </div>


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

                        <label for="phone">
                            Phone number
                        </label>

                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            placeholder="081234567890"
                            value="{{ old('phone') }}"
                            required
                        >

                    </div>


                    <div class="field-2col">

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


                        <div class="field">

                            <label for="password_confirmation">
                                Confirm password
                            </label>

                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="••••••••"
                                required
                            >

                        </div>

                    </div>


                    <button
                        type="submit"
                        class="btn -primary -block"
                    >
                        Create account
                    </button>

                </form>


                <p class="auth-switch">
                    Already have an account?
                    <a href="{{ route('login') }}">
                        Log in
                    </a>
                </p>

            </div>

        </div>

    </div>


    <script src="{{ asset('js/script.js') }}"></script>

</body>

</html>