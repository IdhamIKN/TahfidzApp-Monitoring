<?php

namespace App\Http\Resources\Jurnal;

use Illuminate\Http\Resources\Json\JsonResource;

class JurnalResource extends JsonResource
{
	/**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'id_guru' => $this->id_guru,
            'jampel' => $this->jampel,
            'pertemuan' => $this->pertemuan,
            'materi' => $this->materi,
            'indikator' => $this->indikator,
            'pencapaian' => $this->pencapaian,
            'kehadiran' => $this->kehadiran,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

}
