<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantResource extends JsonResource {
    public function toArray($request) {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'url' => $this->url,
            'redirect_url' => $this->url . "?utm_source=cashback_gr_app",
            'logo' => $this->logo,
//            'image_url' => env('APP_URL') . '/images/latest-shop-1.webp',
            'image_url' => $this->logo,
            //cashback rate - added for demonstration purposes, random value between 1% and 5%
            'cashback_rate' => rand(1, 5) . '%',
        ];
    }
}
