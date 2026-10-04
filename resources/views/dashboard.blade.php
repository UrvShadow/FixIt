<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard — FixIT</title>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<header class="nav">
  <div class="container">
    <a href="{{ route('home') }}" class="brand"><span class="mark">FX</span>FixIT</a>
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="btn -secondary -sm">Log out</button>
    </form>
  </div>
</header>

<section>
  <div class="container">
    <div class="section-head">
      <div class="section-tag">User dashboard</div>
      <h2>Welcome back, {{ auth()->user()->name }}</h2>
    </div>

    <div class="grid-3">
      <div class="svc-card">
        <h3>Account</h3>
        <p>Email: {{ auth()->user()->email }}<br>Phone: {{ auth()->user()->phone }}</p>
      </div>
      <div class="svc-card">
        <h3>Active repairs</h3>
        <p style="font-size: 28px; color: var(--text);">0</p>
      </div>
      <div class="svc-card">
        <h3>Recent orders</h3>
        <p>No repair orders yet.</p>
      </div>
    </div>
    <div style="margin-top: 32px;">
      <a href="{{ route('repairs.create') }}" class="btn -primary">Submit a Repair</a>
      <a href="{{ route('repairs.index') }}" class="btn -secondary">View Repair History</a>
    </div>
  </div>
</section>
</body>
</html>