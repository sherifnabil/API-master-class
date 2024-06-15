<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\API\V1\ReplaceTicketRequest;
use App\Models\Ticket;
use App\Http\Requests\API\V1\StoreTicketRequest;
use App\Http\Requests\API\V1\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Policies\V1\TicketPolicy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketController extends ApiController
{
    protected $policyClass = TicketPolicy::class;

    public function index(TicketFilter $filters)
    {
        return TicketResource::collection(Ticket::filter($filters)->paginate());
    }

    public function store(StoreTicketRequest $request): JsonResource|JsonResponse
    {
        $this->isAble('store', Ticket::class);

        $ticket = Ticket::create($request->mappedAttributes());
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
        $this->isAble('update', $ticket);

        $ticket->update($request->mappedAttributes());
        return new TicketResource($ticket);
    }

    public function replace(ReplaceTicketRequest $request, Ticket $ticket)
    {
        $this->isAble('replace', $ticket);

        $ticket->update($request->mappedAttributes());
        return new TicketResource($ticket);
    }

    public function destroy(Ticket $ticket)
    {
        $this->isAble('delete', $ticket);

        $ticket->delete();
        return $this->ok('Ticket Deleted Successfully.');
    }
}
