<?php

namespace App\Http\Requests\API\V1;

use App\Permissions\V1\Abilities;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTicketRequest extends BaseTicketRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $authorIdAttr = $this->routeIs('tickets.store') ? 'data.relationships.author.data.id' : 'author';
        $authorRule = 'required|exists:users,id';
        $user = Auth::user();

        $rules =  [
            'data.attributes.title' =>  ['required', 'string'],
            'data.attributes.description' =>  ['required', 'string'],
            'data.attributes.status' =>  ['required', 'string', 'in:A,C,H,X'],
            $authorIdAttr =>  $authorRule . '|size:' . $user->id,
        ];

        if($user->tokenCan(Abilities::CreateTicket)) {
            $rules[$authorIdAttr] = $authorRule;
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        if($this->routeIs('author.tickets.store')) {
            $this->merge([
                'author' =>  $this->route('author')
            ]);
        }
    }
}
