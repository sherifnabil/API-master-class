<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type'  =>  'author',
            'id'    =>  $this->id,
            'attributes'    =>  [
                'name'  =>  $this->name,
                'email'  =>  $this->email,
                'isManger'  =>  $this->is_manger,
                $this->mergeWhen( $request->routeIs('authors.*'), [
                    'emailVerifiedAt'   =>  $this->email_verified_at,
                    'createdAt'   =>  $this->created_at,
                    'updatedAt'   =>  $this->updated_at,
                ])
            ],
            'includes'  =>  [TicketResource::collection($this->whenLoaded('tickets'))],
            'links' =>  [
                'self'  =>  route('authors.show', ['author' => $this->id])
            ]
        ];
    }
}
