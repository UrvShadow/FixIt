<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FixIT</title>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<!-- NAVBAR -->
<header class="nav">
  <div class="container">
    <a href="/" class="brand"><span class="mark">FX</span>FixIT</a>
    <nav class="nav-links">
      <a href="#home">Home</a>
      <a href="#services">Services</a>
      <a href="#how-it-works">How It Works</a>
      <a href="#tracking">Track Repair</a>
      <a href="#promo">Promo</a>
    </nav>
    <div class="nav-actions">
      <a href="/login" class="btn -secondary -sm">Log in</a>
      <a href="/register" class="btn -primary -sm">Get Started</a>
    </div>
    <button class="nav-toggle" aria-label="Open menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>
  <div class="nav-mobile">
    <a href="#home">Home</a>
    <a href="#services">Services</a>
    <a href="#how-it-works">How It Works</a>
    <a href="#tracking">Track Repair</a>
    <a href="#promo">Promo</a>
    <div class="nav-mobile-actions">
      <a href="/login" class="btn -secondary -sm -block">Log in</a>
      <a href="/register" class="btn -primary -sm -block">Get Started</a>
    </div>
  </div>
</header>

<!-- HERO -->
<section class="hero" id="home">
  <div class="container">
    <div class="hero-copy">
      <h1>Repair made simple.</h1>
      <p>FixIT connects you with trusted repair technicians for phones, laptops, computers, and household equipment — submit a request, watch the status update, and get your device back.</p>
      <div class="hero-actions">
        <a href="/register" class="btn -primary">Get Started</a>
        <a href="#services" class="btn -secondary">Explore Services</a>
      </div>
      <div class="hero-trust">
        <div class="item"><strong>100+</strong><span>Repairs completed</span></div>
        <div class="item"><strong>5+</strong><span>Verified technicians</span></div>
        <div class="item"><strong>4.8/5</strong><span>Average rating</span></div>
      </div>
    </div>

    <div class="ticket">
      <div class="ticket-top">
        <div>
          <div class="label">Order</div>
          <div class="value">#FX-2026-001</div>
        </div>
        <span class="stamp -active"><span class="dot"></span>In progress</span>
      </div>
      <div class="ticket-device">ASUS Laptop — Screen replacement</div>
      <div class="ticket-issue">Cracked display, flickering on startup</div>
      <div class="ticket-steps">
        <div class="tstep -done"><div class="node"></div><span>Order submitted</span></div>
        <div class="tstep -done"><div class="node"></div><span>Request confirmed</span></div>
        <div class="tstep -done"><div class="node"></div><span>Device inspected</span></div>
        <div class="tstep -active"><div class="node"></div><span>Repair in progress</span></div>
        <div class="tstep -todo"><div class="node"></div><span>Ready for pickup</span></div>
      </div>
    </div>
  </div>
</section>

<!-- SERVICES -->
<section id="services">
  <div class="container">
    <div class="section-head">
      <div class="section-tag">Service catalog</div>
      <h2>Find the right repair service</h2>
      <p>Browse by device type and see estimated pricing and turnaround before you book.</p>
    </div>
    <div class="grid-4">

      <div class="svc-card">
        <div class="svc-icon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><rect x="7" y="2" width="10" height="20" rx="2" stroke="currentColor" stroke-width="1.6"/><line x1="10" y1="19" x2="14" y2="19" stroke="currentColor" stroke-width="1.6"/></svg>
        </div>
        <h3>Smartphone Repair</h3>
        <p>Screen, battery, charging port, and water damage repair for all major brands.</p>
        <div class="svc-meta"><span class="price">from Rp50.000</span><span class="time">1–2 hrs</span></div>
      </div>

      <div class="svc-card">
        <div class="svc-icon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="12" rx="1.5" stroke="currentColor" stroke-width="1.6"/><line x1="2" y1="19" x2="22" y2="19" stroke="currentColor" stroke-width="1.6"/></svg>
        </div>
        <h3>Laptop Repair</h3>
        <p>Hardware diagnostics, screen and keyboard replacement, hinge and battery fixes.</p>
        <div class="svc-meta"><span class="price">from Rp100.000</span><span class="time">1–3 days</span></div>
      </div>

      <div class="svc-card">
        <div class="svc-icon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="11" rx="1.5" stroke="currentColor" stroke-width="1.6"/><line x1="9" y1="19" x2="15" y2="19" stroke="currentColor" stroke-width="1.6"/><line x1="12" y1="15" x2="12" y2="19" stroke="currentColor" stroke-width="1.6"/></svg>
        </div>
        <h3>Computer Repair</h3>
        <p>Desktop builds, component swaps, virus removal, and performance tune-ups.</p>
        <div class="svc-meta"><span class="price">from Rp150.000</span><span class="time">1–2 days</span></div>
      </div>

      <div class="svc-card">
        <div class="svc-icon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/><path d="M19 12a7 7 0 0 0-.2-1.6l1.9-1.5-2-3.4-2.2.9a7 7 0 0 0-2.8-1.6L13.3 2h-2.6l-.4 2.8a7 7 0 0 0-2.8 1.6l-2.2-.9-2 3.4L5.2 10.4A7 7 0 0 0 5 12" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>
        </div>
        <h3>Electronics Repair</h3>
        <p>TVs, audio equipment, gaming consoles, and other household electronics.</p>
        <div class="svc-meta"><span class="price">from Rp50.000</span><span class="time">2–4 days</span></div>
      </div>

    </div>
  </div>
</section>

<!-- WHY FIXIT -->
<section>
  <div class="container">
    <div class="section-head">
      <div class="section-tag">Why FixIT</div>
      <h2>A more transparent way to get things fixed</h2>
    </div>
    <div class="grid-4">
      <div class="benefit">
        <span class="num">01</span>
        <div>
          <h3>Easy to use</h3>
          <p>Submit your repair request in a few steps, with no account back-and-forth or phone tag.</p>
        </div>
      </div>
      <div class="benefit">
        <span class="num">02</span>
        <div>
          <h3>Transparent process</h3>
          <p>Track your repair progress from intake to completion.</p>
        </div>
      </div>
      <div class="benefit">
        <span class="num">03</span>
        <div>
          <h3>Trusted service</h3>
          <p>Connect with repair services through a transparent platform.</p>
        </div>
      </div>
      <div class="benefit">
        <span class="num">04</span>
        <div>
          <h3>Convenient</h3>
          <p>Manage every device, request, and payment from one dashboard.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section id="how-it-works">
  <div class="container">
    <div class="section-head">
      <div class="section-tag">Process</div>
      <h2>How it works</h2>
      <p>From choosing a service to getting your device back, in four steps.</p>
    </div>
    <div class="steps">
      <div class="step">
        <div class="step-code">01</div>
        <h3>Choose a service</h3>
        <p>Find the repair category that matches your device and issue.</p>
      </div>
      <div class="step">
        <div class="step-code">02</div>
        <h3>Submit your request</h3>
        <p>Tell us about your device, the problem, and add photos if needed.</p>
      </div>
      <div class="step">
        <div class="step-code">03</div>
        <h3>Repair process</h3>
        <p>A technician is assigned and your device is inspected and repaired.</p>
      </div>
      <div class="step">
        <div class="step-code">04</div>
        <h3>Track & complete</h3>
        <p>Follow progress in real time, then pay and collect your device.</p>
      </div>
    </div>
  </div>
</section>

<!-- TRACKING PREVIEW -->
<section id="tracking">
  <div class="container">
    <div class="section-head">
      <div class="section-tag">Repair tracking</div>
      <h2>Know exactly where your repair stands</h2>
      <p>Every order moves through a clear, visible timeline — no guessing, no unreturned calls.</p>
    </div>

    <div class="track-panel">
      <div class="track-info">
        <div class="label">Order ID</div>
        <div class="id">#FX-2026-001</div>
        <div class="device">ASUS Laptop — Screen replacement</div>
        <span class="stamp -active"><span class="dot"></span>Repair in progress</span>
        <div style="margin-top: 24px;">
          <a href="/login" class="btn -primary">Track Your Repair</a>
        </div>
      </div>
      <div class="progress-rail">
        <div class="prow -done">Order submitted</div>
        <div class="prow -done">Request confirmed</div>
        <div class="prow -done">Technician assigned</div>
        <div class="prow -done">Device inspected</div>
        <div class="prow -active">Repair in progress</div>
        <div class="prow -todo">Repair completed</div>
        <div class="prow -todo">Ready for pickup / delivery</div>
      </div>
    </div>
  </div>
</section>

<!-- PROMOTION -->
<section id="promo">
  <div class="container">
    <div class="promo-banner">
      <div class="promo-copy">
        <div class="tag">Limited-time offer</div>
        <h2>Get 20% off your first repair</h2>
        <p>New to FixIT? Your first repair request comes with a free inspection and 20% off the service cost.</p>
      </div>
      <div class="promo-cta">
        <a href="/register" class="btn -primary">Claim Promo</a>
      </div>
    </div>
  </div>
</section>

<!-- FINAL CTA -->
<section class="final-cta">
  <div class="container">
    <h2>Need something fixed?</h2>
    <p>Find the right repair service and manage your request from start to finish with FixIT.</p>
    <div class="hero-actions">
      <a href="/register" class="btn -primary">Get Started</a>
      <a href="#services" class="btn -secondary">Explore Services</a>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="footer">
  <div class="container">
    <div class="footer-top">
      <div class="footer-brand">
        <a href="/" class="brand"><span class="mark">FX</span>FixIT</a>
        <p>Making repair services simpler, faster, and more transparent.</p>
      </div>
      <div class="footer-col">
        <h4>Navigation</h4>
        <a href="#home">Home</a>
        <a href="#services">Services</a>
        <a href="#how-it-works">How It Works</a>
        <a href="#tracking">Track Repair</a>
        <a href="#promo">Promo</a>
      </div>
      <div class="footer-col">
        <h4>Account</h4>
        <a href="/login">Log in</a>
        <a href="/register">Register</a>
      </div>
      <div class="footer-col">
        <h4>Contact</h4>
        <span>support@fixit.app</span>
        <span>+62 888-0190-2244</span>
        <span>@fixit.app</span>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© 2026 FixIT. All rights reserved.</span>
      <span>Repair Made Simple</span>
    </div>
  </div>
</footer>

<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
