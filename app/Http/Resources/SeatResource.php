<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\JsonResource;

class SeatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $query = DB::table('seats')
        ->select('column', DB::raw('count(*) as total'))
        ->groupBy('column')
        ->get();

        return [
            'nr_rows' => $query[0]->total,
            'columns' => $query
        ];
    }
}
