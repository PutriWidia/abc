<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Inventaris;

class DetailKaryawanController extends Controller
{
    public function show()
    {
        $data = Karyawan::all(); // Tampilkan semua data karyawan
        return response()->json($data);
    }

    public function detail($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        // $karyawan->foto_url = $karyawan->foto ? asset('storage/' . $karyawan->foto) : asset('images/User.png');
        return view('detail-karyawan', compact('karyawan'));
    }

    public function update(Request $request)
    {

        // dd($item);
        $item = Inventaris::find($request->id);
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
        }

        $field = $request->field;
        $value = $request->value;

        if (in_array($field, ['stok_awal', 'rusak'])) {
            $item->$field = $value;
            $item->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Field tidak valid']);
    }

    public function destroy(Request $request)
    {
        $karyawan = Karyawan::findOrFail($request->id); // id dikirim via JavaScript

        $karyawan->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
