<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Kostum;
use App\Models\OrderItem;
use DB; // Untuk transaksi
use App\Models\HistoryOrder;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Requests\MassDestroyOrderRequest;
use App\Models\ProductSchedule; // Import model ProductSchedule

class OrderController extends Controller
{
     public function index()
    {
        abort_if(Gate::denies('profile_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $orders = Order::with('profile')->get(); // Ambil semua orders dengan profile terkait
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // Mendapatkan semua pengguna dan kostum untuk ditampilkan di form
        $users = User::all();  // Menampilkan semua pengguna
        $kostums = Kostum::all(); // Menampilkan semua kostum

        // Menghasilkan kode order otomatis
        $lastOrder = Order::orderBy('created_at', 'desc')->first(); // Ambil order terakhir
        $newOrderCode = $lastOrder ? 'ORD-' . str_pad((substr($lastOrder->kode_order, 4) + 1), 5, '0', STR_PAD_LEFT) : 'ORD-00001';

        // Tampilkan form untuk membuat order dengan kode order yang baru
        return view('admin.orders.create', compact('users', 'kostums', 'newOrderCode'));
    }

    public function store(StoreOrderRequest $request)
{
    // Mulai transaksi untuk memastikan kedua proses (order dan product schedule) berhasil atau gagal bersama-sama
    DB::beginTransaction();

    try {
        // Menghasilkan kode order otomatis
        $lastOrder = Order::orderBy('created_at', 'desc')->first(); // Ambil order terakhir
        $newOrderCode = $lastOrder ? 'ORD-' . str_pad((substr($lastOrder->kode_order, 4) + 1), 5, '0', STR_PAD_LEFT) : 'ORD-00001';

        // Menambahkan kode_order ke data request yang akan diinsert
        $request->merge(['kode_order' => $newOrderCode]);

        // Membuat order baru
        $order = Order::create($request->validated());  // Pastikan data masuk ke database

        // Proses untuk setiap item (kostum) yang diterima untuk order
        $orderItemsData = $request->get('items', []); // Ambil data items dari request atau kosongkan jika tidak ada

        foreach ($orderItemsData as $item) {
            // Validasi item
            if (!isset($item['kostum_id'], $item['qty'], $item['total'], $item['tanggal_mulai'], $item['tanggal_akhir'])) {
                throw new \Exception('Missing required fields for order item.');
            }

            // Menyimpan data order_item
            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'kostum_id' => $item['kostum_id'],
                'qty' => $item['qty'],
                'total' => $item['total'],
            ]);

            // Update status produk menjadi "Terbooking"
            $kostum = Kostum::find($item['kostum_id']);
            if ($kostum && $kostum->status == 'Tersedia') {
                $kostum->update(['status' => 'Terbooking']);
            }

            // Simpan ke product_schedules
            ProductSchedule::create([
                'kostum_id' => $item['kostum_id'],
                'tanggal_mulai' => $item['tanggal_mulai'],
                'tanggal_akhir' => $item['tanggal_akhir'],
                'jumlah_dibooking' => $item['qty'],
                'status' => 'Booked',
            ]);
        }

        // Commit transaksi jika tidak ada error
        DB::commit();

        return redirect()->route('admin.orders.index')->with('success', 'Order created successfully.');
    } catch (\Exception $e) {
        // Rollback jika terjadi kesalahan
        DB::rollBack();
        return redirect()->route('admin.orders.index')->with('error', 'Error creating order: ' . $e->getMessage());
    }
}

    public function edit(Order $order)
    {
        $users = User::all(); // Get all users for the selection
        return view('admin.orders.edit', compact('order', 'users'));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        // Mengecek jika status order berubah menjadi "Selesai"
        if ($request->status === 'Selesai' && $order->status !== 'Selesai') {
            // Menambahkan data ke tabel history_orders
            HistoryOrder::create([
                'order_id' => $order->id,
                'tanggal_selesai' => now(), // Menyimpan tanggal selesai (tanggal saat ini)
                'total_bayar' => $order->total, // Total pembayaran dari order
                'status' => 'Selesai', // Status history yang diubah
            ]);

            // Proses Pengembalian untuk setiap order item
            foreach ($order->orderItems as $orderItem) {
                // Pastikan masa sewa sudah lewat dan hitung keterlambatannya
                if (\Carbon\Carbon::parse($orderItem->tanggal_akhir)->isPast()) {
                    $tanggalKembali = now(); // Tanggal pengembalian saat ini
                    $keterlambatan = $tanggalKembali->diffInDays($orderItem->tanggal_akhir, false); // Menghitung keterlambatan

                    // Tentukan status pengembalian
                    $status = $keterlambatan > 0 ? 'Terlambat' : 'Sudah Dikembalikan'; // Jika terlambat, statusnya 'Terlambat'

                    // Menyimpan pengembalian ke tabel pengembalians
                    Pengembalian::create([
                        'order_item_id' => $orderItem->id,
                        'tanggal_kembali' => $tanggalKembali,
                        'keterlambatan' => $keterlambatan > 0 ? $keterlambatan : null, // Menyimpan keterlambatan, jika ada
                        'status' => $status,
                    ]);
                }
            }

            // Update status order
            $order->update($request->validated());
        }

        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully.');
    }

    public function updateReturnStatus()
    {
        // Ambil semua produk yang masa sewanya sudah lewat
        $orderItems = OrderItem::where('status', 'Terbooking') // Produk yang sudah dibooking
            ->where('tanggal_akhir', '<', Carbon::now()) // Masa sewa sudah lewat
            ->get();

        foreach ($orderItems as $orderItem) {
            // Update status produk menjadi "Tersedia"
            $kostum = $orderItem->kostum; // Mengambil kostum terkait
            if ($kostum && $kostum->status == 'Terbooking') {
                $kostum->update(['status' => 'Tersedia']); // Mengubah status menjadi "Tersedia"
            }

            // (Optional) Update status di order item jika diperlukan
            $orderItem->update(['status' => 'Selesai']);
        }

        return redirect()->route('admin.orders.index')->with('success', 'Status produk diperbarui menjadi Tersedia.');
    }

    public function destroy(Order $order)
    {
        // Delete the order and related product schedules
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }

    public function massDestroy(MassDestroyOrderRequest $request)
    {
        // Mass delete orders by IDs
        Order::whereIn('id', $request->validated()['ids'])->delete();

        return response()->json(['success' => 'Orders deleted successfully.']);
    }
}
