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
            <input type="text" id="searchInput" placeholder="Search">
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
    <strong>Total Pendapatan:</strong> <span id="totalPendapatan">Rp. 0</span><br>
    <strong>Total Pengeluaran:</strong> <span id="totalPengeluaran">Rp. 0</span><br>
    <strong>Pendapatan Bersih:</strong> <span id="totalPendapatanBersih">Rp. 0</span>
</div>

<script>
    document.getElementById('searchInput').addEventListener('input', filterTable);
    document.getElementById('filter-select').addEventListener('change', filterTable);

    function filterTable() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        const filterValue = document.getElementById('filter-select').value;
        const rows = document.querySelectorAll('.report-table tbody tr');
        const today = new Date();
        
        rows.forEach(row => {
            const nameText = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const dateText = row.querySelector('td:nth-child(3)').textContent;
            const rowDate = new Date(dateText.split('/').reverse().join('-'));

            let isVisible = nameText.includes(searchInput);
            if (filterValue === "Harian") isVisible = isVisible && (rowDate.toDateString() === today.toDateString());
            if (filterValue === "Mingguan") isVisible = isVisible && isInThisWeek(rowDate);
            if (filterValue === "Bulanan") isVisible = isVisible && (rowDate.getMonth() === today.getMonth() && rowDate.getFullYear() === today.getFullYear());

            row.style.display = isVisible ? '' : 'none';
        });

        // Update total setelah filter
        updateTotal();
    }

    function isInThisWeek(date) {
        const today = new Date();
        const start = new Date(today.setDate(today.getDate() - today.getDay()));
        const end = new Date(start);
        end.setDate(start.getDate() + 6);
        return date >= start && date <= end;
    }

    // Fungsi untuk hitung total secara dinamis
    function updateTotal() {
        const rows = document.querySelectorAll('.report-table tbody tr');
        let totalPendapatan = 0;
        let totalPengeluaran = 0;
        let totalPendapatanBersih = 0;

        rows.forEach(row => {
            if (row.style.display !== 'none') {
                const pendapatan = parseInt(row.querySelector('td:nth-child(5)').textContent.replace(/[^0-9]/g, '')) || 0;
                const pengeluaran = parseInt(row.querySelector('td:nth-child(6)').textContent.replace(/[^0-9]/g, '')) || 0;
                const bersih = parseInt(row.querySelector('td:nth-child(7)').textContent.replace(/[^0-9]/g, '')) || 0;

                totalPendapatan += pendapatan;
                totalPengeluaran += pengeluaran;
                totalPendapatanBersih += bersih;
            }
        });

        document.getElementById('totalPendapatan').textContent = "Rp. " + totalPendapatan.toLocaleString();
        document.getElementById('totalPengeluaran').textContent = "Rp. " + totalPengeluaran.toLocaleString();
        document.getElementById('totalPendapatanBersih').textContent = "Rp. " + totalPendapatanBersih.toLocaleString();
    }

    // Jalankan updateTotal() pertama kali saat halaman load
    document.addEventListener("DOMContentLoaded", updateTotal);
</script>

</body>
</html>