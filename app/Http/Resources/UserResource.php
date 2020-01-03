<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'user_id'       => $this->id,
            'username'      => $this->name,
            'user_email'    => $this->email,
            'create'        => $this->created_at,
            'update'        => $this->updated_at,
            'posts'         => PostResource::collection($this->posts),
        ];
    }
}
