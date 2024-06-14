<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Filters\V1\TicketFilter;
use App\Models\Ticket;
use App\Http\Requests\API\V1\StoreTicketRequest;
use App\Http\Requests\API\V1\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;

class TicketController extends ApiController
{

    public function index(TicketFilter $filters)
    {
        return TicketResource::collection(Ticket::filter($filters)->paginate());
        // if($this->include('author')) {
        //     return TicketResource::collection(Ticket::with(['user'])->paginate());
        // }

        // return TicketResource::collection(Ticket::paginate());
    }

    public function store(StoreTicketRequest $request)
    {
        //
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
        //
    }
}
