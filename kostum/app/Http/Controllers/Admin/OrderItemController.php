<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Kostum;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderItemRequest;
use App\Http\Requests\UpdateOrderItemRequest;
use App\Http\Requests\MassDestroyOrderItemRequest;

class OrderItemController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::with('order', 'kostum')->get();  // Dengan relasi Order dan Kostum
        return view('admin.order-items.index', compact('orderItems'));
    }

    // Menambahkan order item baru
    public function store(StoreOrderItemRequest $request)
    {
        $validatedData = $request->validated();  // Validasi input data
        $orderItem = OrderItem::create($validatedData);

        return redirect()->route('admin.order-items.index')->with('success', 'Order item created successfully.');
    }

    // Update order item
    public function update(UpdateOrderItemRequest $request, OrderItem $orderItem)
    {
        $validatedData = $request->validated();  // Validasi input data
        $orderItem->update($validatedData);  // Update data order item

        return redirect()->route('admin.order-items.index')->with('success', 'Order item updated successfully.');
    }

    // Hapus order item
    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();
        return redirect()->route('admin.order-items.index')->with('success', 'Order Item deleted successfully.');
    }

    // Mass destroy (hapus beberapa item sekaligus)
    public function massDestroy(Request $request)
    {
        $ids = $request->input('ids');
        OrderItem::whereIn('id', $ids)->delete();
        return response()->json(['success' => 'Items deleted successfully']);
    }

    public function create()
{
    // Fetch the orders from the database
    $orders = Order::all();

    // Fetch kostums as well
    $kostums = Kostum::all();

    // Pass the orders and kostums to the view
    return view('admin.order-items.create', compact('orders', 'kostums'));
}

}
