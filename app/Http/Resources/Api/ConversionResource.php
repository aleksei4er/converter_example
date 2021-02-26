<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ConversionResource extends JsonResource
{
    public static $wrap = false;
    
    public $preserveKeys = true;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'currency_from' => $this->currency_from,
            'currency_to' => $this->currency_to,
            'value' => $this->value,
            'converted_value' => $this->converted_value,
            'rate' => $this->rate,
            'created_at' => $this->created_at
        
        ];
    }
}
