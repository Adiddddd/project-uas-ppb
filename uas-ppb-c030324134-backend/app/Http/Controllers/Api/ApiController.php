<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gudang;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    // 1. API LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // Cek user dan kecocokan password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email atau password salah.'
            ], 401);
        }

        // Buat token akses untuk Flutter
        $token = $user->createToken('flutter_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ]
        ], 200);
    }

    // 2. API AMBIL DATA GUDANG
    public function getGudang()
    {
        // Mengambil semua data gudang beserta relasi jenis gudangnya
        $gudang = Gudang::with('jenisGudang')->get();

        return response()->json([
            'status' => 'success',
            'data' => $gudang
        ], 200);
    }

    // 3. API AMBIL DATA PROFIL
    public function getProfile(Request $request)
    {
        // Mengembalikan data user yang sedang login berdasarkan tokennya
        return response()->json([
            'status' => 'success',
            'user' => $request->user()
        ], 200);
    }

    // API AMBIL DATA JENIS GUDANG
    public function getJenisGudang()
    {
        $jenis = \App\Models\JenisGudang::all();

        return response()->json([
            'status' => 'success',
            'data' => $jenis
        ], 200);
    }

    // API TAMBAH DATA GUDANG (POST)
    public function storeGudang(Request $request)
    {
        $gudang = new \App\Models\Gudang();
        $gudang->nama_gudang = $request->nama_gudang;
        $gudang->id_jenis_gudang = $request->id_jenis_gudang;
        $gudang->luas_gudang = $request->luas_gudang;
        $gudang->volume_gudang = $request->volume_gudang;
        $gudang->keterangan = $request->keterangan;
        $gudang->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil ditambahkan'
        ], 201);
    }

    // API EDIT DATA GUDANG (PUT)
    public function updateGudang(Request $request, $id)
    {
        $gudang = \App\Models\Gudang::find($id);
        if ($gudang) {
            $gudang->nama_gudang = $request->nama_gudang;
            $gudang->id_jenis_gudang = $request->id_jenis_gudang;
            $gudang->luas_gudang = $request->luas_gudang;
            $gudang->volume_gudang = $request->volume_gudang;
            $gudang->keterangan = $request->keterangan;
            $gudang->save();
            
            return response()->json(['status' => 'success', 'message' => 'Data diupdate'], 200);
        }
        
        return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
    }

    // API HAPUS DATA GUDANG (DELETE)
    public function deleteGudang($id)
    {
        $gudang = \App\Models\Gudang::find($id);
        if ($gudang) {
            $gudang->delete();
            return response()->json(['status' => 'success', 'message' => 'Data dihapus'], 200);
        }
        
        return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
    }
}