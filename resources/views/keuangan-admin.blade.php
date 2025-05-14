<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan (Admin)</title>
    <link rel="stylesheet" href="css/keuangan-admin.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">

        <!-- Header -->
        <header class="header">
            <a href="{{ url('/admin-home') }}" class="back-button">
                <img src="{{ asset('images/Back.png') }}" alt="Back">
            </a>
            <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="logo">
            <div class="user-info">
                <span>Admin</span>
                <img src="{{ asset('images/User.png') }}" alt="User" class="user-icon">
            </div>
        </header>

        <!-- Search -->
        <div class="search-bar">
            <input type="text" placeholder="Search">
        </div>

        <!-- Filter -->
        <div class="filter">
            <label for="filter-select">Filter:</label>
            <select id="filter-select">
                <option>Harian</option>
                <option selected>Mingguan</option>
                <option>Bulanan</option>
            </select>
        </div>

       <!-- Tabel -->
<table class="report-table">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Pendapatan</th>
            <th>Pengeluaran</th>
            <th>Pendapatan Bersih</th>
        </tr>
    </thead>
    <tbody>
        <!-- <tr onclick="location.href='/laporan-keuangan-harian';" style="cursor: pointer;">
            <td>1.</td><td>User123</td><td>05/05/2025</td><td>07.30 - 15.30</td>
            <td>Rp. 1.000.000</td><td>Rp. 200.000</td><td>Rp. 800.000</td>
        </tr>
        <tr onclick="location.href='/laporan-keuangan-harian';" style="cursor: pointer;">
            <td>2.</td><td>User123</td><td>07/05/2025</td><td>07.30 - 15.30</td>
            <td>Rp. 2.000.000</td><td>Rp. 500.000</td><td>Rp. 1.500.000</td>
        </tr>
        <tr onclick="location.href='/laporan-keuangan-harian';" style="cursor: pointer;">
            <td>3.</td><td>User456</td><td>08/05/2025</td><td>07.30 - 15.30</td>
            <td>Rp. 3.000.000</td><td>Rp. 800.000</td><td>Rp. 2.200.000</td>
        </tr>
        <tr onclick="location.href='/laporan-keuangan-harian';" style="cursor: pointer;">
            <td>4.</td><td>User123</td><td>09/05/2025</td><td>07.30 - 15.30</td>
            <td>Rp. 1.000.000</td><td>Rp. 200.000</td><td>Rp. 800.000</td>
        </tr>
        <tr onclick="location.href='/laporan-keuangan-harian';" style="cursor: pointer;">
            <td>5.</td><td>User456</td><td>10/05/2025</td><td>07.30 - 15.30</td>
            <td>Rp. 2.000.000</td><td>Rp. 400.000</td><td>Rp. 1.600.000</td>
        </tr>
        <tr onclick="location.href='/laporan-keuangan-harian';" style="cursor: pointer;">
            <td>6.</td><td>User456</td><td>11/05/2025</td><td>07.30 - 15.30</td>
            <td>Rp. 3.000.000</td><td>Rp. 700.000</td><td>Rp. 2.300.000</td>
        </tr>
        <tr onclick="location.href='/laporan-keuangan-harian';" style="cursor: pointer;">
            <td>7.</td><td>User456</td><td>12/05/2025</td><td>07.30 - 15.30</td>
            <td>Rp. 4.000.000</td><td>Rp. 900.000</td><td>Rp. 3.100.000</td>
        </tr> -->
        <!-- onclick="location.href='/laporan-keuangan-harian';" style="cursor: pointer;" -->
        @foreach($data as $no => $index)
        <tr >
            <td>{{$no+1}}</td>
            <td><a href="/dataCatatanKaryawan/{{$index->nama_karyawan}}">{{ $index->nama_karyawan }}</a></td>
            <td>{{ $index->tanggal }}</td>
            <td>07.30 - 15.30</td>
            <td>{{ $index->pendapatan }}</td>
            <td>{{ $index->pengeluaran }}</td>
            <td>{{ $index->pendapatan_bersih }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Total -->
<div class="total">
    <strong>Total Pendapatan:</strong> Rp. 16.000.000<br>
    <strong>Total Pengeluaran:</strong> Rp. 3.700.000<br>
    <strong>Pendapatan Bersih:</strong> Rp. 12.300.000
</div>

