<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHistoryOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Jika diperlukan, tambahkan pengecekan role atau izin
    }

    public function rules()
    {
        return [
            'order_id' => 'required|exists:orders,id',
            'tanggal_selesai' => 'required|date',
            'total_bayar' => 'required|integer',
            'status' => 'required|in:Selesai,Dibatalkan',
        ];
    }

    public function messages()
    {
        return [
            'order_id.required' => 'Order ID harus dipilih.',
            'tanggal_selesai.required' => 'Tanggal selesai harus diisi.',
            'total_bayar.required' => 'Total pembayaran harus diisi.',
            'status.required' => 'Status harus dipilih.',
        ];
    }
}
