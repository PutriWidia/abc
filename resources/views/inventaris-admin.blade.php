<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Inventaris Admin</title>
    <link rel="stylesheet" href="{{ asset('css/invetaris-admin.css') }}">
</head>
<body>

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

<!-- Tab Navigasi Kategori -->
<nav class="category-nav">
    <div class="category-actions">
      <div class="dropdown">
        <select onchange="location = this.value;">
          <option disabled selected>Pilih Kategori</option>
          <option value="{{ url('/inventaris-admin?tab=skuter') }}" {{ $tab == 'skuter' ? 'selected' : '' }}>Skuter</option>
          <option value="{{ url('/inventaris-admin?tab=mobil') }}" {{ $tab == 'mobil' ? 'selected' : '' }}>Mobil</option>
          <option value="{{ url('/inventaris-admin?tab=motor') }}" {{ $tab == 'motor' ? 'selected' : '' }}>Motor</option>
          <option value="{{ url('/inventaris-admin?tab=styrofoam') }}" {{ $tab == 'styrofoam' ? 'selected' : '' }}>Styrofoam</option>
        </select>
      </div>
    </div>
  </nav>

<main>
    <!-- Tabel Inventaris -->
    <table class="inventory-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Id</th>
                <th>Jenis</th>
                <th>Stok Awal</th>
                <th>Rusak</th>
                <th>Stok saat ini</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}.</td>
                <td>{{ $item['id'] }}</td>
                <td>{{ $item['jenis'] }}</td>
                <td>
                    <div class="controls">
                        {{-- <button class="rounded" onclick="decrement(this, 'stok_awal')">-</button> --}}
                        <form action="{{ route('kurang') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <button class="rounded" type="submit">-</button>
                            {{-- <button class="rounded" onclick="increment(this, 'stok_awal')">+</button> --}}
                        </form>
                        <span class="count">{{ $item['stok_awal'] }}</span>
                        <form action="{{ route('tambah') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <button class="rounded" type="submit">+</button>
                            {{-- <button class="rounded" onclick="increment(this, 'stok_awal')">+</button> --}}
                        </form>
                    </div>
                </td>
                <td>
                    <div class="controls">
                        {{-- <button class="rounded" onclick="decrement(this, 'rusak')">-</button> --}}
                        <form action="{{ route('kurangiRusak') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <button class="rounded" type="submit">-</button>
                            {{-- <button class="rounded" onclick="increment(this, 'stok_awal')">+</button> --}}
                        </form>
                        <span class="count">{{ $item['rusak'] }}</span>
                        <form action="{{ route('tambahiRusak') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <button class="rounded" type="submit">+</button>
                            {{-- <button class="rounded" onclick="increment(this, 'stok_awal')">+</button> --}}
                        </form>
                        {{-- <button class="rounded" onclick="increment(this, 'rusak')">+</button> --}}
                    </div>
                </td>
                <td>{{ $item['stok_awal'] - $item['rusak'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Total -->
    <div class="total">
        <strong>
            Tersedia saat ini:
            {{ $data->sum(fn($item) => $item['stok_awal'] - $item['rusak']) }}
        </strong>
    </div>
   <div class="add-btn-wrapper left">
    <button class="add-btn">+</button>
</div>


</main>

<!-- Form Tambah Barang -->
<div id="addModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>

        <form action="{{ route('inventaris.tambah') }}" method="POST">
            @csrf
            <label for="kategori">Kategori:</label>
            <select name="kategori" required>
            <option value="skuter">Skuter</option>
            <option value="mobil">Mobil</option>
            <option value="motor">Motor</option>
            <option value="styrofoam">Styrofoam</option>
            </select>

            <label for="jenis">Jenis:</label>
            <input type="text" name="jenis" required placeholder="Contoh: Skuter Listrik">

            <label for="stok_awal">Stok Awal:</label>
            <input type="number" name="stok_awal" required min="0">

            <label for="rusak">Jumlah Rusak:</label>
            <input type="number" name="rusak" value="0" min="0">

            <button type="submit">Tambah</button>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('addModal');
    const addBtn = document.querySelector('.add-btn');

    addBtn.addEventListener('click', () => {
        modal.style.display = 'block';
    });

    function closeModal() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    }

    function updateValue(id, field, value, span) {
    fetch('/inventaris/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ id, field, value })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            span.textContent = value;
            updateStokSaatIni(span);
        }
    });
}

function increment(button, field) {
    const span = button.parentElement.querySelector('.count');
    let value = parseInt(span.textContent);
    const id = button.closest('tr').children[1].textContent;

    updateValue(id, field, value + 1, span);
}

function decrement(button, field) {
    const span = button.parentElement.querySelector('.count');
    let value = parseInt(span.textContent);
    if (value <= 0) return;

    const id = button.closest('tr').children[1].textContent;

    updateValue(id, field, value - 1, span);
}


    function updateStokSaatIni(span) {
        const row = span.closest('tr');
        const stok = parseInt(row.children[3].querySelector('.count').textContent);
        const rusak = parseInt(row.children[4].querySelector('.count').textContent);
        row.children[5].textContent = stok - rusak;
    }

</script>


</body>
</html>
