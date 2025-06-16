<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MassDestroyHistoryOrderRequest extends FormRequest
{
    public function authorize()
    {
        // Pastikan hanya admin yang dapat menghapus secara massal
        return auth()->check() && auth()->user()->hasRole('admin');
    }

    public function rules()
    {
        return [
            'ids' => 'required|array|min:1',  // Pastikan ID yang dipilih ada
            'ids.*' => 'exists:history_orders,id',  // Pastikan setiap ID yang dipilih ada di tabel history_orders
        ];
    }

    public function messages()
    {
        return [
            'ids.required' => 'Pilih data yang akan dihapus.',
            'ids.*.exists' => 'Data yang dipilih tidak ditemukan.',
        ];
    }
}
