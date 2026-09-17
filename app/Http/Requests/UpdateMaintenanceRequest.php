<?php

namespace App\Http\Requests;


class UpdateMaintenanceRequest extends StoreMaintenanceRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'asset_id' => ['required', 'exists:assets,id'],
            'jenis_pemeliharaan' => ['required', 'string', 'max:255'],
            'maintenance_date' => ['required', 'date'],
            'jatuh_tempo' => ['required', 'date', 'after_or_equal:maintenance_date'],
            'priority' => ['required', 'in:rendah,sedang,tinggi'],
            'recurrence' => ['required', 'in:tidak,mingguan,bulanan,tahunan'],
            'vendor' => ['required', 'string', 'max:255'],
            'kontak_vendor' => ['required', 'string', 'max:255'],
            'cost' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:1000'],

            'documents' => ['nullable', 'array'],
            'documents.*' => ['file', 'mimes:pdf,docx,jpg,jpeg,png', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'jatuh_tempo.after_or_equal' => 'Jadwal jatuh tempo tidak boleh sebelum tanggal pemeliharaan.',
            'documents.*.mimes' => 'Dokumen harus berformat PDF, DOCX, JPG, atau PNG.',
            'documents.*.max' => 'Ukuran tiap dokumen maksimal 10MB.',
        ];
    }
}