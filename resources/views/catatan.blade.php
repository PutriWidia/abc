<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="{{ asset('css/catatan.css') }}">
  <title>Daftar Permainan</title>
</head>
<body>
    <header>
        <div class="container">

          <!-- Kiri -->
          <div class="header-left">
            <a href="{{ url('/karyawan-home') }}" class="back-button">
              <img src="{{ asset('images/Back.png') }}" alt="Back">
            </a>
            <input type="text" placeholder="Search nama permainan/ket...." class="search-bar" />
          </div>

          <!-- Tengah -->
          <div class="header-center">
            <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="logo">
          </div>

          <!-- Kanan -->
          <div class="header-right">
            <div class="user-top">
              <p class="tanggal">Tanggal: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
              <div class="user-info">
                <img src="{{ asset('images/User.png') }}" alt="User" class="user-icon" />
                <span class="username">
                    {{ Auth::guard('karyawan')->check() ? Auth::guard('karyawan')->user()->name : 'Guest' }}
                </span>
              </div>
            </div>

            <div class="button-group">
              <button>Done</button>
              <button id="addCustomerButton" type="button">+ Add Customer</button>
            </div>
          </div>

        </div>
      </header>



      <table>
        <thead>
          <tr>
            <th></th>
            <th>No.</th>
            <th>Nama Permainan</th>
            <th>Waktu</th>
            <th>Harga</th>
            <th>Status Pembayaran</th>
            <th>Ket.</th>
          </tr>
        </thead>
        <tbody id="catatanTbody">
            @foreach ($catatan as $index => $item)

          <tr class="{{ isset($item['waktu_habis']) && $item['waktu_habis'] ? 'expired' : '' }}">

          <td>
            <input type="hidden" name="laporan_id[]" value="{{ $item['id'] }}">
            <input
              type="checkbox"
              name="laporan_cek[]"
              value="{{ $item['id'] }}"
              style="transform: scale(0.8);"
              {{ $item['checked'] ? 'checked' : '' }}
              onchange="updateCheckboxStatus({{ $item['id'] }}, this.checked)"
            >
          </td>

          <td>{{ $index + 1 }}.</td>

            {{-- Dropdown Permainan --}}
            <td>
              <select name="nama_permainan" class="dropdown-permainan">
                <option value="Skuter" {{ isset($item['nama']) && $item['nama'] == 'Skuter' ? 'selected' : '' }}>Skuter</option>
<option value="Mobil" {{ isset($item['nama']) && $item['nama'] == 'Mobil' ? 'selected' : '' }}>Mobil</option>
<option value="Motor" {{ isset($item['nama']) && $item['nama'] == 'Motor' ? 'selected' : '' }}>Motor</option>
<option value="Melukis" {{ isset($item['nama']) && $item['nama'] == 'Melukis' ? 'selected' : '' }}>Melukis</option>
<option value="Rumah Pintar" {{ isset($item['nama']) && $item['nama'] == 'Rumah Pintar' ? 'selected' : '' }}>Rumah Pintar</option>

              </select>
            </td>

            {{-- Waktu + countdown atau label habis --}}
            <td>
              {{ $item['waktu'] }}
              @if(isset($item['waktu_habis']) && $item['waktu_habis'])
                <br><small>Waktu habis</small>
              @elseif(isset($item['sisa_waktu']))
                <br><small>{{ $item['sisa_waktu'] }}</small>
              @endif
            </td>

            <td>{{ number_format($item['harga'], 0, ',', '.') }}</td>

            {{-- Dropdown Status --}}
            <td>
              <select
                name="status_pembayaran"
                class="dropdown-status {{ strtolower($item['status']) }}"
                onchange="updateSelectStyle(this, {{ $item['id'] }})"
              >
                <option value="Lunas" {{ $item['status'] == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                <option value="Belum" {{ $item['status'] == 'Belum' ? 'selected' : '' }}>Belum</option>
              </select>
            </td>

            <td class="editable" data-id="{{ $item['id'] }}">
              <span class="keterangan-text">{{ $item['keterangan'] }}</span>
              <input type="text" class="keterangan-input" value="{{ $item['keterangan'] }}" style="display:none" />
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

      <!-- Modal -->

      <div id="addCustomerModal" class="modal" style="display: none;">
    <div class="modal-content">
      <span class="close-btn" onclick="closeModal()">&times;</span>

      <form action="{{ route('catatan.tambah') }}" method="POST">
        @csrf
        <label for="nama_permainan">Nama Permainan:</label>
        <select name="nama_permainan" id="namaPermainanSelect" onchange="updateHarga()" required>
          <option value="Skuter">Skuter</option>
          <option value="Mobil">Mobil</option>
          <option value="Motor">Motor</option>
          <option value="Melukis">Melukis</option>
          <option value="Rumah Pintar">Rumah Pintar</option>
        </select>

        <label for="waktu">Waktu:</label>
        <input type="text" id="waktuInput" name="waktu" readonly required>


        <label for="harga">Harga:</label>
        <input type="number" id="hargaInput" name="harga" value="15000" required>

        <label for="status">Status Pembayaran:</label>
        <select name="status" required>
          <option value="Lunas">Lunas</option>
          <option value="Belum">Belum</option>
        </select>

        <label for="keterangan">Keterangan:</label>
        <input type="text" name="keterangan" placeholder="Opsional..." value="{{ old('keterangan') }}">

        <button type="submit">Tambah</button>
      </form>
    </div>
  </div>

  <script>
    const modal = document.getElementById('addCustomerModal');
    const addBtn = document.getElementById('addCustomerButton');

  // Menutup modal saat tombol close diklik
  function closeModal() {
    modal.style.display = 'none';
  }

  // Menutup modal jika area luar modal diklik
  window.onclick = function(event) {
    if (event.target === modal) {
      modal.style.display = 'none';
    }
  };

  function updateHarga() {
    const permainan = document.getElementById('namaPermainanSelect').value;
    const hargaInput = document.getElementById('hargaInput');
    if (permainan === 'Skuter') {
      hargaInput.value = 10000;
    } else {
      hargaInput.value = 15000;
    }
  }

  function updateWaktu() {
    const permainan = document.getElementById('namaPermainanSelect').value;
    const waktuInput = document.getElementById('waktuInput');

    const now = new Date();
    let end = new Date(now);

    const format = (date) =>
    date.toTimeString().slice(0, 5); // HH:MM format


    if (permainan === 'Skuter') {
    end.setMinutes(now.getMinutes() + 20);
    waktuInput.value = `${format(now)} - ${format(end)}`;
  } else if (permainan == 'Melukis' || permainan == 'Rumah Pintar') {
    waktuInput.value = format(now);
    return;
  } else {
    end.setMinutes(now.getMinutes() + 15);
    waktuInput.value = `${format(now)} - ${format(end)}`;
  }

}

document.getElementById('namaPermainanSelect').addEventListener('change', updateWaktu);
window.onload = updateWaktu;




  function tandaiWaktuHabis() {
    const rows = document.querySelectorAll('#catatanTbody tr');

    const now = new Date();
    const nowMinutes = now.getHours() * 60 + now.getMinutes();

    rows.forEach(row => {
      const waktuCell = row.querySelector('td:nth-child(4)'); // kolom Waktu

      if (!waktuCell) return;

      const waktuText = waktuCell.textContent.trim(); // contoh: "08:00 - 08:20" atau "08:00"

      const parts = waktuText.split('-');

      if (parts.length === 2) {
        const endTime = parts[1].trim(); // ambil "08:20"
        const [endHour, endMinute] = endTime.split(':').map(Number);
        const endTotalMinutes = endHour * 60 + endMinute;

        if (nowMinutes >= endTotalMinutes) {
          row.classList.add('expired');
        }
      }
    });
  }

  // Panggil fungsi saat halaman sudah selesai dimuat
  window.addEventListener('DOMContentLoaded', tandaiWaktuHabis);
  setInterval(tandaiWaktuHabis, 60000); // cek ulang tiap 1 menit


  function updateSelectStyle(selectElement, id) {
    const status = selectElement.value;

    // Kirim data ke server
    fetch('{{ route('catatan.updateStatus') }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({
        id: id,
        status: status
      })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        // Berhasil update, langsung update tampilan
        selectElement.classList.remove('lunas', 'belum');
        selectElement.classList.add(status.toLowerCase());
      } else {
        alert('Gagal update status');
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
  }

  let selectedCheckboxes = {};

  function pindahKeBawahCheckbox() {
  const checkboxes = document.querySelectorAll('input[type="checkbox"]');
  const tbody = document.getElementById('catatanTbody');

  checkboxes.forEach((checkbox, index) => {
    const tr = checkbox.closest('tr');

    if (selectedCheckboxes[index]) {
      checkbox.checked = true;
      tbody.appendChild(tr);
    }

    checkbox.addEventListener('change', function () {
      if (this.checked) {
        selectedCheckboxes[index] = true;
        tbody.appendChild(tr);
      } else {
        selectedCheckboxes[index] = false;
        tbody.prepend(tr);
      }
    });
  });
}

function addCustomerHandler() {
  // Ambil status checkbox saat ini
  const checkboxes = document.querySelectorAll('input[type="checkbox"]');

  checkboxes.forEach(checkbox => {
    // Jika checkbox sudah dicentang, pindahkan baris ke bawah
    if (checkbox.checked) {
      const tr = checkbox.closest('tr');
      const tbody = document.getElementById('catatanTbody');
      tbody.appendChild(tr); // Pindahkan baris ke bawah
    }
  });

  pindahKeBawahCheckbox();
}

// Event listener untuk modal add customer
addBtn.addEventListener('click', () => {
  modal.style.display = 'block';
  updateHarga();
  addCustomerHandler(); // Panggil fungsi ini setelah modal muncul dan customer ditambahkan
});

// Panggil fungsi ketika halaman sudah siap
document.addEventListener('DOMContentLoaded', () => {
  pindahKeBawahCheckbox(); // Panggil untuk memindahkan baris ke bawah ketika checkbox dicentang
});

function updateCheckboxStatus(id, status) {
  fetch('{{ route('catatan.updateCheckbox') }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({
      id: id,
      checked: status
    })
  })
  .then(response => response.json())
  .then(data => {
    if (!data.success) {
      alert('Gagal update checkbox');
    }
  });
}

// Event listener untuk tombol Done
document.querySelector('.button-group button').addEventListener('click', function () {
    const selectedCheckboxes = document.querySelectorAll('input[name="laporan_cek[]"]:checked');

    if (selectedCheckboxes.length > 0) {
        const selectedItems = Array.from(selectedCheckboxes).map(checkbox => {
            const row = checkbox.closest('tr');
            return {
                id: checkbox.value,
                idData: row.querySelector('input[name="laporan_id[]"]').value,
                nama_permainan: row.querySelector('select[name="nama_permainan"]').value,
                harga: row.querySelector('td:nth-child(5)').textContent.trim(),
                status: row.querySelector('select[name="status_pembayaran"]')?.value || 'belum dibayar'
            };
        });

        fetch('{{ route('laporan-keuangan.tambah') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ laporan: selectedItems })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                selectedCheckboxes.forEach(checkbox => {
                    const row = checkbox.closest('tr');
                    row.remove();
                });
                alert('Data berhasil dipindahkan ke laporan keuangan.');
            } else {
                alert('Gagal memindahkan data ke laporan keuangan: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan.');
        });
    } else {
        alert('Pilih catatan terlebih dahulu.');
    }
});


document.querySelector('.search-bar').addEventListener('input', function () {
  const searchTerm = this.value.toLowerCase(); // Ambil kata kunci pencarian, dan ubah jadi huruf kecil
  const rows = document.querySelectorAll('#catatanTbody tr'); // Ambil semua baris tabel

  rows.forEach(row => {
    const namaPermainan = row.querySelector('td:nth-child(3)').textContent.toLowerCase(); // Nama Permainan
    const keterangan = row.querySelector('td:nth-child(7)').textContent.toLowerCase(); // Keterangan
    
    // Cek jika salah satu kolom mengandung kata kunci pencarian
    if (namaPermainan.includes(searchTerm) || keterangan.includes(searchTerm)) {
      row.style.display = ''; // Tampilkan baris
    } else {
      row.style.display = 'none'; // Sembunyikan baris
    }
  });
});


// Tambahkan event listener pada setiap dropdown "Nama Permainan" di tabel
document.querySelectorAll('.dropdown-permainan').forEach(select => {
    select.addEventListener('change', function() {
        const row = this.closest('tr');
        const selectedPermainan = this.value;
        const hargaCell = row.querySelector('td:nth-child(5)');
        const id = row.querySelector('td input[type="checkbox"]').value; // Ambil ID berdasarkan checkbox
        let harga;

        // Tentukan harga berdasarkan permainan yang dipilih
        if (selectedPermainan === 'Skuter') {
            harga = 10000;
        } else {
            harga = 15000;
        }

        // Update harga di kolom
        hargaCell.textContent = harga.toLocaleString();

        // Kirim perubahan nama permainan dan harga ke server
        fetch('{{ route('catatan.updatePermainan') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                id: id,
                nama_permainan: selectedPermainan,
                harga: harga
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Data permainan berhasil diperbarui!');
            } else {
                alert('Gagal memperbarui data permainan.');
            }
        })
        .catch(error => console.error('Error:', error));
    });
});


// Panggil updateHarga() pada modal saat dropdown permainan diubah
document.getElementById('namaPermainanSelect').addEventListener('change', updateHarga);




// Menangani double click pada kolom keterangan untuk mengeditnya
document.querySelectorAll('.editable').forEach(function(cell) {
  cell.addEventListener('dblclick', function() {
    const input = cell.querySelector('.keterangan-input');
    const text = cell.querySelector('.keterangan-text');
    
    // Sembunyikan teks dan tampilkan input
    text.style.display = 'none';
    input.style.display = 'block';
    input.focus();
  });
});

// Menangani event Enter untuk menyimpan perubahan
document.querySelectorAll('.keterangan-input').forEach(function(input) {
  input.addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
      const newKeterangan = input.value;
      const rowId = input.closest('.editable').dataset.id; // Ambil id dari data-id

      // Kirim data yang sudah diedit ke server (gunakan fetch)
      fetch('{{ route('catatan.updateKeterangan') }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
          id: rowId,
          keterangan: newKeterangan
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Berhasil update, tampilkan kembali teks keterangan dan sembunyikan input
          input.style.display = 'none';
          input.previousElementSibling.style.display = 'block';
          input.previousElementSibling.textContent = newKeterangan;
        } else {
          alert('Gagal menyimpan perubahan.');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan.');
      });
    }
  });
});



  </script>
</body>
</html>
