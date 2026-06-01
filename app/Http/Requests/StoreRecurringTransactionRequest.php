<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecurringTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:150',
            'amount' => 'required|numeric|min:0.01',
            'recurring_frequency' => 'required|in:weekly,monthly,yearly',
            'description' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'Jumlah yang harus dibayar harus diisi.',
            'amount.numeric' => 'Jumlah harus berupa angka.',
            'amount.min' => 'Jumlah harus lebih dari 0.',
            'title.required' => 'Judul transaksi harus diisi.',
            'title.max' => 'Judul transaksi maksimal 150 karakter.',
            'recurring_frequency.required' => 'Pilih jenis recurring.',
            'recurring_frequency.in' => 'Pilih mingguan, bulanan, atau tahunan.',
        ];
    }
}
