<?php

namespace App\Http\Resources;

use App\Models\Epresences;
use Illuminate\Http\Resources\Json\JsonResource;

class EpresenceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $out = Epresences::where('id_user', $this->id_user)->where('type', 'OUT')->whereDate('waktu', date('d-m-Y', strtotime($this->waktu)))->first();
        return [
            'id_user' => $this->id_user,
            'nama_user' => $this->user->name,
            'hari' => date('l', strtotime($this->waktu)),
            'tanggal' => date('d-m-Y', strtotime($this->waktu)),
            'waktu_masuk' => date('H:i:s', strtotime($this->waktu)),
            'waktu_pulang' => $out ? date('H:i:s', strtotime($out->waktu)) : '-',
            'status_masuk' => (is_null($this->is_approve) ? '-' : ($this->is_approve ? 'APPROVE' : 'REJECT')),
            'status_pulang' => (is_null($out) ? '-' : (is_null($out->is_approve) ? '-': ($out->is_approve ? 'APPROVE' : 'REJECT')))
        ];
    }
}
