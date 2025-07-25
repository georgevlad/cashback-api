<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource {
    public function toArray($request) {
        return [
            'name' => $this->name,
            'code' => (string) $this->code,
            'description' => $this->description,
            'url' => $this->url,
            'image_url' => env('APP_URL') . '/images/latest-product-1.webp',
//            'image_url' => $this->image_url,
        ];
    }
}
