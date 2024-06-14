<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Filters\V1\TicketFilter;
use App\Models\Ticket;
use App\Http\Requests\API\V1\StoreTicketRequest;
use App\Http\Requests\API\V1\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketController extends ApiController
{

    public function index(TicketFilter $filters)
    {
        return TicketResource::collection(Ticket::filter($filters)->paginate());
    }

    public function store(StoreTicketRequest $request): JsonResource|JsonResponse
    {
        $user = User::findOrFail($request->input('data.relationships.author.data.id'));

        $model = [
            'title' =>  $request->input('data.attributes.title'),
            'description' =>  $request->input('data.attributes.description'),
            'status' =>  $request->input('data.attributes.status'),
            'user_id' => $user->id,
        ];

        $ticket = Ticket::create($model);

        return new TicketResource($ticket);
    }

    public function show(Ticket $ticket)
    {
        if($this->include('author')) {
            return new TicketResource($ticket->load('author'));
        }
        return new TicketResource($ticket);
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        //
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return $this->ok('Ticket Deleted Successfully.');
    }
}
