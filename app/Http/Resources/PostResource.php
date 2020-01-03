<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'post_id' => $this->id,
            'post_title' => $this->title,
            'post_body' => $this->body,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'add_by'    => $this->user->email,

        ];
    }
}
