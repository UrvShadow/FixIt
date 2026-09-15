<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard — FixIT</title>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<header class="nav">
  <div class="container">
    <a href="{{ route('home') }}" class="brand"><span class="mark">FX</span>FixIT Admin</a>
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="btn -secondary -sm">Log out</button>
    </form>
  </div>
</header>

<section>
  <div class="container">
    <div class="section-head">
      <div class="section-tag">Admin dashboard</div>
      <h2>Welcome, {{ auth()->user()->name }}</h2>
    </div>

    <div class="grid-4">
      <div class="svc-card">
        <h3>Total users</h3>
        <p style="font-size: 28px; color: var(--text);">{{ $totalUsers }}</p>
      </div>
      <div class="svc-card">
        <h3>Active repairs</h3>
        <p style="font-size: 28px; color: var(--text);">0</p>
      </div>
      <div class="svc-card">
        <h3>Completed repairs</h3>
        <p style="font-size: 28px; color: var(--text);">0</p>
      </div>
      <div class="svc-card">
        <h3>Transactions</h3>
        <p style="font-size: 28px; color: var(--text);">0</p>
      </div>
    </div>
  </div>
</section>

</body>
</html>