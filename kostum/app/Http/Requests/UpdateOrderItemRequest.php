<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'order_id' => 'required|exists:orders,id',  // Pastikan order_id valid
            'kostum_id' => 'required|exists:kostums,id',  // Pastikan kostum_id valid
            'qty' => 'required|integer|min:1',  // Jumlah produk yang dipesan harus lebih dari 0
            'durasi_sewa' => 'required|integer|min:1',  // Durasi sewa harus lebih dari 0
            'harga_item' => 'required|numeric|min:1',  // Harga item harus berupa angka lebih dari 0
            'total' => 'required|numeric|min:0',  // Total harga harus berupa angka
            'status' => 'required|in:Perlu Dikembalikan,Selesai',  // Status yang valid
        ];
    }
}
