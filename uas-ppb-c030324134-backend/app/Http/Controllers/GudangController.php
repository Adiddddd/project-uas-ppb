<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use App\Models\JenisGudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function index()
    {
        $gudangs = Gudang::with('jenisGudang')->get();
        return view('gudang.index', compact('gudangs'));
    }

    public function create()
    {
        $jenisGudangs = JenisGudang::all();
        return view('gudang.create', compact('jenisGudangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_gudang' => 'required',
            'id_jenis_gudang' => 'required',
            'luas_gudang' => 'required|numeric',
            'volume_gudang' => 'required|numeric',
            'keterangan' => 'nullable',
        ]);

        Gudang::create($request->all());

        return redirect()->route('gudang.index')
            ->with('success', 'Data gudang berhasil ditambahkan');
    }

    public function edit(Gudang $gudang)
    {
        $jenisGudangs = JenisGudang::all();

        return view('gudang.edit', compact('gudang', 'jenisGudangs'));
    }

    public function update(Request $request, Gudang $gudang)
    {
        $request->validate([
            'nama_gudang' => 'required',
            'id_jenis_gudang' => 'required',
            'luas_gudang' => 'required|numeric',
            'volume_gudang' => 'required|numeric',
            'keterangan' => 'nullable',
        ]);

        $gudang->update($request->all());

        return redirect()->route('gudang.index')
            ->with('success', 'Data gudang berhasil diubah');
    }

    public function destroy(Gudang $gudang)
    {
        $gudang->delete();

        return redirect()->route('gudang.index')
            ->with('success', 'Data gudang berhasil dihapus');
    }
}