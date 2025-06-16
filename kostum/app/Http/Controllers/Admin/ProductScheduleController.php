<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kostum;
use Illuminate\Http\Request;
use App\Models\ProductSchedule;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductScheduleRequest;
use App\Http\Requests\UpdateProductScheduleRequest;
use App\Http\Requests\MassDestroyProductScheduleRequest;

class ProductScheduleController extends Controller
{
    // Mass Destroy (penghapusan massal)
    public function massDestroy(MassDestroyProductScheduleRequest $request)
    {
        ProductSchedule::whereIn('id', $request->ids)->delete(); // Menghapus semua jadwal produk berdasarkan ID yang dikirimkan

        return response()->json(['success' => 'Product Schedule deleted successfully.']);
    }

    // Store (menyimpan jadwal produk baru)
    public function store(StoreProductScheduleRequest $request)
    {
        // Menyimpan produk jadwal baru
        $productSchedule = ProductSchedule::create($request->validated());

        return redirect()->route('admin.product-schedules.index')->with('success', 'Product Schedule created successfully.');
    }

    // Update (memperbarui jadwal produk)
    public function update(UpdateProductScheduleRequest $request, ProductSchedule $productSchedule)
    {
        // Memperbarui jadwal produk
        $productSchedule->update($request->validated());

        return redirect()->route('admin.product-schedules.index')->with('success', 'Product Schedule updated successfully.');
    }

    // Menampilkan semua jadwal produk (index)
    public function index()
    {
        $productSchedules = ProductSchedule::with('kostum')->get(); // Mendapatkan jadwal produk beserta kostumnya
        return view('admin.product-schedules.index', compact('productSchedules'));
    }

    // Menampilkan form untuk membuat jadwal produk baru
    public function create()
    {
        $kostums = Kostum::all(); // Mengambil semua kostum untuk ditampilkan di form
        return view('admin.product-schedules.create', compact('kostums'));
    }

    // Menampilkan form untuk mengedit jadwal produk
    public function edit(ProductSchedule $productSchedule)
    {
        $kostums = Kostum::all(); // Mengambil semua kostum untuk ditampilkan di form edit
        return view('admin.product-schedules.edit', compact('productSchedule', 'kostums'));
    }

    // Menampilkan detail jadwal produk
    public function show(ProductSchedule $productSchedule)
    {
        return view('admin.product-schedules.show', compact('productSchedule'));
    }
}
