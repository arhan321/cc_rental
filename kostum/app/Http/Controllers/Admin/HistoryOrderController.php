<?php

namespace App\Http\Controllers\Admin;

use App\Models\HistoryOrder;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHistoryOrderRequest;
use App\Http\Requests\UpdateHistoryOrderRequest;
use App\Http\Requests\MassDestroyHistoryOrderRequest;

class HistoryOrderController extends Controller
{
    // Menampilkan Daftar History Order
    public function index()
    {
        $historyOrders = HistoryOrder::all(); // Anda bisa menggunakan paginate() jika data banyak

        return view('admin.history-orders.index', compact('historyOrders'));
    }

    // Menampilkan Form untuk Membuat History Order
    public function create()
    {
        $orders = Order::all();  // Ambil semua order untuk ditampilkan di dropdown

        return view('admin.history-orders.create', compact('orders'));
    }

    // Menyimpan Data History Order
    public function store(StoreHistoryOrderRequest $request)
    {
        // Validasi sudah dilakukan oleh StoreHistoryOrderRequest
        $validatedData = $request->validated();

        // Simpan data history order
        HistoryOrder::create($validatedData);

        return redirect()->route('admin.history-orders.index')->with('success', 'History order berhasil disimpan.');
    }

    // Menampilkan Form untuk Mengedit History Order
    public function edit($id)
    {
        $historyOrder = HistoryOrder::findOrFail($id);
        $orders = Order::all();  // Ambil semua order untuk ditampilkan di dropdown

        return view('admin.history-orders.edit', compact('historyOrder', 'orders'));
    }

    // Memperbarui Data History Order
    public function update(UpdateHistoryOrderRequest $request, $id)
    {
        // Validasi sudah dilakukan oleh UpdateHistoryOrderRequest
        $validatedData = $request->validated();

        // Temukan history order berdasarkan ID
        $historyOrder = HistoryOrder::findOrFail($id);

        // Perbarui data history order
        $historyOrder->update($validatedData);

        return redirect()->route('admin.history-orders.index')->with('success', 'History order berhasil diperbarui.');
    }

    // Menghapus History Order Secara Massal
    public function massDestroy(MassDestroyHistoryOrderRequest $request)
    {
        // Mengambil ID yang dipilih untuk dihapus
        $ids = $request->input('ids');

        // Hapus history order berdasarkan ID yang dipilih
        HistoryOrder::whereIn('id', $ids)->delete();

        return response()->json(['success' => 'History order berhasil dihapus.']);
    }
}
