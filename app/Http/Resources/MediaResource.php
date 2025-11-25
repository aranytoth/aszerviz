<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
{
    return [
        'id' => $this->id,
        'file_name' => $this->file_name,
        'original_url' => $this->getUrl(),
        // Itt kéred le a thumb URL-t.
        // A 'thumb' nevet akkor használd, ha így nevezted el a konverziót!
        'thumb_url' => $this->hasGeneratedConversion('thumb') 
                        ? $this->getUrl('thumb') 
                        : $this->getUrl(), // Fallback az eredetire, ha még nincs kész a thumb
        'mime_type' => $this->mime_type,
        'size' => $this->human_readable_size,
    ];
}
}
