@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Edit Data Gudang</h2>

    {{-- Menampilkan Error Validasi jika ada --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('gudang.update', $gudang->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- Wajib ada untuk proses Update/Put di Laravel --}}

        <div class="mb-3">
            <label for="nama_gudang" class="form-label">Nama Gudang</label>
            <input type="text" class="form-control" id="nama_gudang" name="nama_gudang" 
                   value="{{ old('nama_gudang', $gudang->nama_gudang) }}" required>
        </div>

        <div class="mb-3">
            <label for="id_jenis_gudang" class="form-label">Jenis Gudang</label>
            <select class="form-select" id="id_jenis_gudang" name="id_jenis_gudang" required>
                <option value="">-- Pilih Jenis Gudang --</option>
                @foreach($jenisGudangs as $jenis)
                    <option value="{{ $jenis->id }}" 
                        {{ old('id_jenis_gudang', $gudang->id_jenis_gudang) == $jenis->id ? 'selected' : '' }}>
                        {{ $jenis->nama_jenis_gudang }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="luas_gudang" class="form-label">Luas Gudang (m²)</label>
            <input type="number" class="form-control" id="luas_gudang" name="luas_gudang" 
                   value="{{ old('luas_gudang', $gudang->luas_gudang) }}" required>
        </div>

        <div class="mb-3">
            <label for="volume_gudang" class="form-label">Volume Gudang (m³)</label>
            <input type="number" class="form-control" id="volume_gudang" name="volume_gudang" 
                   value="{{ old('volume_gudang', $gudang->volume_gudang) }}" required>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $gudang->keterangan) }}</textarea>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-warning">Update Data</button>
            <a href="{{ route('gudang.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection