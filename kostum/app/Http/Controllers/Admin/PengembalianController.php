<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pengembalian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePengembalianRequest;
use App\Http\Requests\UpdatePengembalianRequest;

class PengembalianController extends Controller
{
    public function store(StorePengembalianRequest $request)
{
    // Validasi sudah dilakukan oleh StorePengembalianRequest
    $validatedData = $request->validated();

    // Simpan data pengembalian
    Pengembalian::create($validatedData);

    return redirect()->route('admin.pengembalians.index')->with('success', 'Pengembalian berhasil disimpan.');
}

    // Update Method
    public function update(UpdatePengembalianRequest $request, $id)
{
    // Validasi sudah dilakukan oleh UpdatePengembalianRequest
    $validatedData = $request->validated();

    // Temukan pengembalian berdasarkan ID
    $pengembalian = Pengembalian::findOrFail($id);

    // Perbarui data pengembalian
    $pengembalian->update($validatedData);

    return redirect()->route('admin.pengembalians.index')->with('success', 'Pengembalian berhasil diperbarui.');
}

    // Mass Destroy Method
    public function massDestroy(Request $request)
    {
        // Validasi input, pastikan ada id yang dikirimkan
        $ids = $request->input('ids');
        if ($ids) {
            // Hapus data pengembalian yang dipilih
            Pengembalian::whereIn('id', $ids)->delete();
            return response()->json(['success' => 'Pengembalian berhasil dihapus.']);
        }

        return response()->json(['error' => 'Tidak ada data yang dipilih.'], 400);
    }

    public function index()
{
    // Ambil semua data pengembalian
    $pengembalians = Pengembalian::all(); // Anda bisa menggunakan paginate() jika data banyak

    return view('admin.pengembalians.index', compact('pengembalians'));
}


}
