<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;

class BaseTicketRequest extends FormRequest
{
    public function mappedAttributes(array $otherAttributes = [])
    {
        $attributeMap = array_merge([
            'data.attributes.title' =>  'title',
            'data.attributes.description' =>  'description',
            'data.attributes.status' =>  'status',
            'data.attributes.createdAt' =>  'created_at',
            'data.attributes.updatedAt' =>  'updated_at',

            'data.relationships.author.data.id' => 'user_id',
        ], $otherAttributes);

        $attributesToUpdate = [];
        foreach ($attributeMap as $key => $attribute) {
            if($this->has($key)) {
                $attributesToUpdate[$attribute] = $this->input($key);
            }
        }

        return $attributesToUpdate;
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
