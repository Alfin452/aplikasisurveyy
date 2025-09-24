<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUnitKerjaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'unit_kerja_name' => [
                'required',
                'string',
                'max:255',
                // INI ADALAH KODE YANG SUDAH DIPERBAIKI
                // Mengambil model 'unit_kerja' dari route secara eksplisit
                Rule::unique('unit_kerjas')->ignore($this->route('unit_kerja')),
            ],
            'uk_short_name'   => 'nullable|string|max:50',
            'parent_id'       => 'nullable|exists:unit_kerjas,id',
            'tipe_unit_id'    => 'required|exists:tipe_units,id',
            'contact'         => 'nullable|string|max:100',
            'address'         => 'nullable|string',
            'start_time'      => 'nullable|date_format:H:i',
            'end_time'        => 'nullable|date_format:H:i|after:start_time',
        ];
    }
}
