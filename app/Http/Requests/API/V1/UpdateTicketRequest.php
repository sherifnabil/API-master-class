<?php

namespace App\Http\Requests\API\V1;

use App\Permissions\V1\Abilities;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateTicketRequest extends BaseTicketRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'data.attributes.title' =>  ['sometimes', 'string'],
            'data.attributes.description' =>  ['sometimes', 'string'],
            'data.attributes.status' =>  ['sometimes', 'string', 'in:A,C,H,X'],
            'data.relationships.author.data.id' => ['prohibited'],
        ];

        if(Auth::user()->tokenCan(Abilities::UpdateTicket)) {
            $rules['data.relationships.author.data.id'] = ['sometimes', 'exists:users,id'];
        }

        return $rules;
    }
}
