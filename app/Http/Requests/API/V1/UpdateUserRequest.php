<?php

namespace App\Http\Requests\API\V1;

class UpdateUserRequest extends BaseUserRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'data.attributes.name' =>  ['sometimes', 'string'],
            'data.attributes.email' =>  ['sometimes', 'email'],
            'data.attributes.isManger' =>  ['sometimes', 'boolean'],
            'data.attributes.password' =>  ['sometimes', 'string'],
        ];
    }
}
