<?php

namespace App\Http\Requests\API\V1;

use App\Permissions\V1\Abilities;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends BaseTicketRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules =  [
            'data.attributes.title' =>  ['required', 'string'],
            'data.attributes.description' =>  ['required', 'string'],
            'data.attributes.status' =>  ['required', 'string', 'in:A,C,H,X'],
        ];

        $user = $this->user();

        if(request()->routeIs('tickets.store')) {
            if($user->tokenCan(Abilities::CreateOwnTicket)) {
                $rules['data.relationships.author.data.id'][] = 'size:' . $user->id;
            }
        }

        return $rules;
    }
}
