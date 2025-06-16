<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePengembalianRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Pastikan hanya admin yang bisa melakukan pengembalian
        return auth()->check() && auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order_item_id' => 'required|exists:order_items,id',
            'tanggal_kembali' => 'required|date',
            'keterlambatan' => 'nullable|integer',
            'status' => 'required|in:Perlu Dikembalikan,Sudah Dikembalikan,Terlambat',
        ];
    }

    /**
     * Custom error messages (optional).
     *
     * @return array
     */
    public function messages()
    {
        return [
            'order_item_id.required' => 'Order item harus dipilih.',
            'order_item_id.exists' => 'Order item yang dipilih tidak valid.',
            'tanggal_kembali.required' => 'Tanggal kembali harus diisi.',
            'tanggal_kembali.date' => 'Tanggal kembali harus berupa tanggal yang valid.',
            'status.required' => 'Status pengembalian harus dipilih.',
            'status.in' => 'Status yang dipilih tidak valid.',
        ];
    }
}
