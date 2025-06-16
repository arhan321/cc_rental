<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKostumRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id', // Validasi category_id yang ada di tabel categories
            'nama_kostum' => 'required|string|max:255',
            'ukuran' => 'required|in:S,M,L,One Size',
            'harga_sewa' => 'required|integer|min:1',
            'stok' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:Tersedia,Terbooking',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
