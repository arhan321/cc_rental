<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kostum;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKostumRequest;
use App\Http\Requests\UpdateKostumRequest;
use App\Http\Requests\MassDestroyKostumRequest;

class KostumController extends Controller
{
    // Mass Destroy (penghapusan massal)
    public function massDestroy(MassDestroyKostumRequest $request)
    {
        Kostum::whereIn('id', $request->ids)->delete(); // Menghapus semua kostum berdasarkan ID yang dikirimkan

        return response()->json(['success' => 'Kostum deleted successfully.']);
    }

    // Store (menyimpan kostum baru)
    public function store(StoreKostumRequest $request)
{
    // Handle the image upload and other fields
    $data = $request->validated();
    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('kostum_images', 'public');
    }

    $kostum = Kostum::create($data);

    return redirect()->route('admin.kostums.index')->with('success', 'Kostum created successfully.');
}

    // Update (memperbarui kostum)
    public function update(UpdateKostumRequest $request, Kostum $kostum)
    {
        // Memperbarui kostum
        $kostumData = $request->validated();
        
        // Jika ada gambar baru, simpan gambar baru
        if ($request->hasFile('image')) {
            $kostumData['image'] = $request->file('image')->store('kostum_images', 'public');
        }

        $kostum->update($kostumData);

        return redirect()->route('admin.kostums.index')->with('success', 'Kostum updated successfully.');
    }

    // Menampilkan semua kostum (index)
    public function index()
    {
        $kostums = Kostum::with('category')->get(); // Mendapatkan kostum beserta kategori
        return view('admin.kostums.index', compact('kostums'));
    }

    // Menampilkan form untuk membuat kostum baru
    public function create()
    {
        $categories = Category::all(); // Mengambil semua kategori untuk ditampilkan di form
        return view('admin.kostums.create', compact('categories'));
    }

    // Menampilkan form untuk mengedit kostum
    public function edit(Kostum $kostum)
    {
        $categories = Category::all(); // Mengambil semua kategori untuk ditampilkan di form edit
        return view('admin.kostums.edit', compact('kostum', 'categories'));
    }

    // Menyimpan media (gambar) untuk kostum
    public function storeMedia(Request $request)
{
    // Validasi file yang diunggah
    $request->validate([
        'file' => 'required|image|max:2048', // Gambar dengan ukuran maksimum 2MB
    ]);

    // Menyimpan gambar ke public storage
    if ($request->hasFile('file')) {
        $path = $request->file('file')->store('kostum_images', 'public');
        
        // Mengembalikan nama file setelah di-upload
        return response()->json(['name' => $path]);
    }

    return response()->json(['error' => 'No file uploaded.'], 400);
}

}
