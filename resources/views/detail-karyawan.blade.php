
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lily Toy's</title>
  <link rel="stylesheet" href="{{ asset('css/detail-karyawan.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

  <div class="header">
    <a href="{{ url('/admin-home') }}" class="back-button">
        <img src="{{ asset('images/Back.png') }}" alt="Back">
      </a>
    <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="logo">
  </div>

  <div class="profile-pic">
    <!-- <img src="{{ asset('images/User.png') }}" alt="User" class="user-icon"> -->
    <img src="{{ asset('storage/public/' . $karyawan->foto) }}" alt="Foto Profil" width="100" class="user-icon">

  </div>

  <div class="card">
    <div class="menu" onclick="toggleDropdown()">⋮</div>
    <div class="dropdown" id="dropdownMenu">
      <div onclick="editData()">Edit</div>
      <div onclick="hapusData()">Hapus</div>
    </div>
    <p><span class="label">Nama</span>     : {{ $karyawan->username }}</p>
    <p><span class="label">Email</span>    : {{ $karyawan->email }}</p>
    <p><span class="label">Jenis Kelamin</span>: {{ $karyawan->jenis_kelamin }}</p>
    <p><span class="label">No.Telp</span>: {{ $karyawan->no_telp }}</p>
  </div>

  <!-- Modal Edit -->
<div id="editModal" class="modal" style="display: none;">
    <div class="modal-content">
      <span class="close-btn" onclick="closeEditModal()">&times;</span>
      <h2>Edit Data Karyawan</h2>
      <form id="editForm" action="{{ route('karyawan.update') }}" method="POST">
        @csrf
        <input type="hidden" name="id" id="editId" value="{{ $karyawan->id }}">

        <label for="editNama">Nama</label>
        <input type="text" name="nama" id="editNama" required>

        <label for="editEmail">Email</label>
        <input type="email" name="email" id="editEmail" required>

        <label for="editGender">Jenis Kelamin</label>
        <select name="jenis_kelamin" id="editGender" required>
          <option value="L">Laki-laki</option>
          <option value="P">Perempuan</option>
        </select>

        <label for="editPhone">No. Telp</label>
        <input type="text" name="no_telp" id="editPhone" required>

        <label for="editPassword">Password Baru</label>
        <input type="password" name="password" id="editPassword">
        <button type="submit">Simpan</button>
      </form>
    </div>
  </div>

  <script>
    function editData() {
      document.getElementById("editModal").style.display = "flex";
      document.getElementById('editNama').value = '{{ $karyawan->username }}';
      document.getElementById('editEmail').value = '{{ $karyawan->email }}';
      document.getElementById('editPhone').value = '{{ $karyawan->no_telp }}';
      document.getElementById('{{ $karyawan->jenis_kelamin }}').selected = "True";
    //   document.getElementById('editGender').value = '{{ $karyawan->jenis_kelamin }}';
    //   console.log(document.getElementById('editGender').value)
      document.getElementById('editPassword').value = '';
    }

    function closeEditModal() {
      document.getElementById("editModal").style.display = "none";
    }

    function getCsrfToken() {
      return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    }

    // document.getElementById('editForm').addEventListener('submit', function(e) {
    //   e.preventDefault();

    //   const data = {
    //     id: document.getElementById('editId').value,
    //     nama: document.getElementById('editNama').value,
    //     email: document.getElementById('editEmail').value,
    //     jenis_kelamin: document.getElementById('editGender').value,
    //     no_telp: document.getElementById('editPhone').value,
    //     password: document.getElementById('editPassword').value,
    //   };

    //   fetch('/karyawan/update', {
    //     method: 'POST',
    //     headers: {
    //       'Content-Type': 'application/json',
    //       'X-CSRF-TOKEN': getCsrfToken()
    //     },
    //     body: JSON.stringify(data)
    //   })
    //   .then(res => res.json())
    //   .then(response => {
    //     alert(response.message);
    //     location.reload();
    //   })
    //   .catch(error => console.error(error));
    // });

    function hapusData() {
      if (!confirm("Yakin ingin menghapus data?")) return;

      fetch('/karyawan/hapus', {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify({ id: '{{ $karyawan->id }}' })
      })
      .then(res => res.json())
      .then(data => {
        alert(data.message);
        window.location.href = '/admin-home'; // redirect setelah hapus
      })
      .catch(err => console.error(err));
    }

    function toggleDropdown() {
      const dropdown = document.getElementById("dropdownMenu");
      dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    }

    document.addEventListener("click", function(event) {
      const menu = document.querySelector(".menu");
      const dropdown = document.getElementById("dropdownMenu");
      if (!menu.contains(event.target)) {
        dropdown.style.display = "none";
      }
    });
  </script>
</body>
</html>
