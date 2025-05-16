<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lily Toys</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <img src="{{ asset('images/Logo3.png') }}" alt="Logo" class="navbar-logo">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
          <li class="nav-item"><a class="nav-link" href="#visi">Visi</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
          <li class="nav-item dropdown">
            <a class="btn btn-outline-primary dropdown-toggle ms-2" href="#" data-bs-toggle="dropdown">Login</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="/auth/admin-login">Admin</a></li>
              <li><a class="dropdown-item" href="/auth/karyawan-login">Karyawan</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero text-center my-5">
    <div class="container">
      <img src="{{ asset('images/Home.jpg') }}" alt="Home" class="img-fluid rounded">
    </div>
  </section>

<!-- About Section -->
<section class="about-section" id="about">
    <img src="{{ asset('images/Collezioni.jpg') }}" alt="About Us" class="about-img">
  </section>

  <!-- Visi Section -->
  <section class="visi-section" id="visi">
    <img src="{{ asset('images/Visi.jpg') }}" alt="Visi" class="visi-img">
  </section>



  <section class="contact-professional py-5" id="contact">
    <div class="container">
      <div class="row">
        <!-- Kolom 1 -->
        <div class="col-md-4 mb-4">
            <div class="desc">
          <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="img-fluid mb-3" style="max-width: 150px;">
          <p>Kami menyediakan layanan laundry profesional dengan teknologi canggih dan tim berpengalaman.</p>
          <p class="text-muted mt-4">Lily Toy's © 2025. All rights reserved.</p>
        </div>
    </div>

        <!-- Kolom 2 -->
        <div class="col-md-4 mb-4">
          <h5 class="fw-bold border-bottom pb-2">KONTAK KAMI</h5>
          <p><a href="mailto:lilytoys@gmail.com">lilytoys@gmail.com</a><br>0821-2779-8574</p>
        </div>

        <!-- Kolom 3 -->
        <div class="col-md-4 mb-4">
          <h5 class="fw-bold border-bottom pb-2">LOKASI</h5>
          <img src="{{ asset('images/location.jpg') }}" alt="Lokasi" class="img-fluid rounded mb-2" style="max-width: 100%;">
          <p>JL. Pantai Indah Kapuk 2</p>
        </div>
      </div>
    </div>
  </section>


  <!-- Footer -->
  <footer class="text-center py-4 bg-white border-top">
    <p>&copy; 2025 Lily Toys</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
