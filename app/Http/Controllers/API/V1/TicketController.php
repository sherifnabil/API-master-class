<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Ticket;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\StoreTicketRequest;
use App\Http\Requests\API\V1\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;

class TicketController extends Controller
{

    public function index()
    {
        return TicketResource::collection(Ticket::all());
    }

    public function store(StoreTicketRequest $request)
    {
        //
    }

    public function show(Ticket $ticket)
    {
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
