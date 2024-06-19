<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;

class BaseUserRequest extends FormRequest
{
    public function mappedAttributes(array $otherAttributes = [])
    {
        $attributeMap = array_merge([
            'data.attributes.email' =>  'email',
            'data.attributes.name' =>  'name',
            'data.attributes.isManger' =>  'is_manger',
            'data.attributes.password' =>  'password',
        ], $otherAttributes);

        $attributesToUpdate = [];
        foreach ($attributeMap as $key => $attribute) {
            if($this->has($key)) {
                $value = $this->input($key);

                if($attribute === 'password') {
                    $value = bcrypt($attribute);
                }

                $attributesToUpdate[$attribute] = $value;
            }
        }

        return $attributesToUpdate;
    }
}
