<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => 'ticket',
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'description' => $this->when(
                    $request->routeIs('tickets.show'),
                    $this->description
                ),
                'status' => $this->status,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'relationships' =>  [
                'author' => [
                    'data'  =>  [
                        'type'  =>  'authors',
                        'id'    =>  $this->user_id
                    ],
                    'links' =>  [
                        'self'  =>  'todo'
                    ]
                ]
            ],
            'includes'  =>  new UserResource($this->whenLoaded('author')),
            'links' => [
               'self' => route('tickets.show', ['ticket' => $this->id]),
            ],

        ];
    }
}
