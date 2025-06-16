<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductScheduleRequest extends FormRequest
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
            'kostum_id' => 'required|exists:kostums,id', // Ensure the selected kostum exists
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai', // End date must be after or equal to start date
            'jumlah_dibooking' => 'required|integer|min:1',
            'status' => 'required|in:Booked,Selesai,Batal', // Status must be one of the predefined values
        ];
    }
}
