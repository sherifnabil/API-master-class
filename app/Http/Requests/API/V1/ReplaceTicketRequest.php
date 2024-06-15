<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;

class ReplaceTicketRequest extends BaseTicketRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'data.attributes.title' =>  ['required', 'string'],
            'data.attributes.description' =>  ['required', 'string'],
            'data.attributes.status' =>  ['required', 'string', 'in:A,C,H,X'],
            'data.relationships.author.data.id' => ['required', 'exists:users,id'],
        ];
    }
}
