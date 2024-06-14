<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
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

        if(request()->routeIs('tickets.store')) {
            $rules['data.relationships.author.data.id'] = ['required', 'exists:users,id'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'data.attributes.title' =>  'The Title Attribute is required',
            'data.attributes.description' =>  'The Description Attribute is required',
            'data.attributes.status' =>  'The Status Attribute is Invalid please use A, C, H or X',
            'data.relationships.author.data.id'   =>  'The Author ID Attribute is required',
        ];
    }
}
