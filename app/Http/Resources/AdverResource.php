<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [ 
            'id' => $this->id ,
            'a_id' => $this->a_id ,
            'head' => $this->head ,
            'a_price' => $this->a_price ,
            'a_categoryid' => $this->a_categoryid ,
            'a_arrayimage' => $this->a_arrayimage ,
        ];
    }
}
