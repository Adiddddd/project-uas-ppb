@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Tambah Data Gudang</h2>

    {{-- Menampilkan Error Validasi jika ada input yang salah --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('gudang.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nama_gudang" class="form-label">Nama Gudang</label>
            <input type="text" class="form-control" id="nama_gudang" name="nama_gudang" 
                   value="{{ old('nama_gudang') }}" required placeholder="Masukkan nama gudang">
        </div>

        <div class="mb-3">
            <label for="id_jenis_gudang" class="form-label">Jenis Gudang</label>
            <select class="form-select" id="id_jenis_gudang" name="id_jenis_gudang" required>
                <option value="">-- Pilih Jenis Gudang --</option>
                @foreach($jenisGudangs as $jenis)
                    <option value="{{ $jenis->id }}" {{ old('id_jenis_gudang') == $jenis->id ? 'selected' : '' }}>
                        {{ $jenis->nama_jenis_gudang }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="luas_gudang" class="form-label">Luas Gudang (m²)</label>
            <input type="number" class="form-control" id="luas_gudang" name="luas_gudang" 
                   value="{{ old('luas_gudang') }}" required placeholder="Contoh: 100">
        </div>

        <div class="mb-3">
            <label for="volume_gudang" class="form-label">Volume Gudang (m³)</label>
            <input type="number" class="form-control" id="volume_gudang" name="volume_gudang" 
                   value="{{ old('volume_gudang') }}" required placeholder="Contoh: 500">
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Simpan Data</button>
            <a href="{{ route('gudang.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection