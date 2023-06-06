<?php

namespace App\Http\Requests\Jurnal;

use Illuminate\Foundation\Http\FormRequest;

class StoreJurnalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'jampel'     => 'required',
            'pertemuan'  => 'required|string|max:255',
            'materi'     => 'required|string|max:255',
            'indikator'  => 'required|string|max:255',
            'pencapaian' => 'required|string|max:255',
            'kehadiran'  => 'required|string|max:255',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'jampel.required'      => 'Jam pelajaran diperlukan',
            'jampel.date_format'   => 'Format jam pelajaran salah ',
            'pertemuan.required'   => 'Pertemuan diperlukan',
            'pertemuan.string'     => 'Tipe tidak sesuai',
            'pertemuan.max'        => 'Pertemuan maksimal 255 karakter',
            'materi.required'      => 'Materi diperlukan',
            'materi.string'        => 'Tipe tidak sesuai',
            'materi.max'           => 'Materi maksimal 255 karakter',
            'indikator.required'   => 'Indikator diperlukan',
            'indikator.string'     => 'Tipe tidak sesuai',
            'indikator.max'        => 'Indikator maksimal 255 karakter',
            'pencapaian.required'  => 'Pencapaian diperlukan',
            'pencapaian.string'    => 'Tipe tidak sesuai',
            'pencapaian.max'       => 'Pencapaian maksimal 255 karakter',
            'kehadiran.required'   => 'Kehadiran diperlukan',
            'kehadiran.string'     => 'Tipe tidak sesuai',
            'kehadiran.max'        => 'Kehadiran maksimal 255 karakter',
        ];
    }
}
