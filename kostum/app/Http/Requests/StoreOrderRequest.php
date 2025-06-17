<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'profile_id' => 'required|exists:profiles,id', // Relasi ke tabel profiles
            'kode_order' => 'required|unique:orders,kode_order', // Validasi untuk kode_order yang unik
            'tanggal_sewa' => 'required|date', // Validasi untuk tanggal_sewa
            'tanggal_dikembalikan' => 'required|date|after_or_equal:tanggal_sewa', // Validasi untuk tanggal_dikembalikan harus setelah atau sama dengan tanggal_sewa
            'total' => 'required|numeric', // Validasi untuk total harga sewa sebagai angka
            'status' => 'required|in:Menunggu,Diproses,Siap Di Ambil,Selesai', // Validasi untuk status dengan pilihan yang terbatas
        ];
    }
}
