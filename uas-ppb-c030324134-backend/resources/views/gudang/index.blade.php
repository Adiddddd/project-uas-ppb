@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <h2 class="mb-4">Data Gudang</h2>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Gudang</th>
                <th>Jenis Gudang</th>
                <th>Luas</th>
                <th>Volume</th>
                <th>Keterangan</th>
                {{-- 1. Hanya tampilkan judul kolom "Aksi" jika yang login adalah Admin --}}
                @if(auth()->user()->role === 'admin')
                    <th width="170">Aksi</th>
                @endif
            </tr>
        </thead>

        <tbody>
            @forelse($gudangs as $index => $gudang)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $gudang->nama_gudang }}</td>
                <td>{{ $gudang->jenisGudang->nama_jenis_gudang ?? '-' }}</td>
                <td>{{ $gudang->luas_gudang }} m²</td>
                <td>{{ $gudang->volume_gudang }} m³</td>
                <td>{{ $gudang->keterangan ?? '-' }}</td>
                
                {{-- 2. Hanya tampilkan tombol Edit & Hapus beserta kolomnya jika yang login adalah Admin --}}
                @if(auth()->user()->role === 'admin')
                    <td>
                        <a href="{{ route('gudang.edit', $gudang->id) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('gudang.destroy', $gudang->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                @endif
            </tr>
            @empty
            <tr>
                {{-- 3. Colspan otomatis berubah: 7 jika admin (termasuk kolom aksi), atau 6 jika user biasa --}}
                <td colspan="{{ auth()->user()->role === 'admin' ? 7 : 6 }}" class="text-center">
                    Belum ada data gudang
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection