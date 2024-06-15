<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Auth\User;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Resources\V1\TicketResource;
use App\Http\Requests\API\V1\StoreTicketRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Requests\API\V1\UpdateTicketRequest;
use App\Http\Requests\API\V1\ReplaceTicketRequest;

class AuthorTicketsController extends ApiController
{
    public function index($author_id, TicketFilter $filters)
    {
        return TicketResource::collection(
            Ticket::where('user_id', $author_id)
            ->filter($filters)
            ->paginate()
        );
    }

    public function store($author_id, StoreTicketRequest $request): JsonResource|JsonResponse
    {
        $this->isAble('store', Ticket::class);

        $ticket = Ticket::create($request->mappedAttributes());
        return new TicketResource($ticket);
    }

    public function replace(ReplaceTicketRequest $request, $author_id, Ticket $ticket)
    {
        $this->isAble('replace', $ticket);

        $ticket->update($request->mappedAttributes());
        return new TicketResource($ticket);
    }

    public function update(UpdateTicketRequest $request, $author_id, Ticket $ticket)
    {
        $this->isAble('update', $ticket);

        $ticket->update($request->mappedAttributes());
        return new TicketResource($ticket);
    }

    public function destroy($author_id, Ticket $ticket)
    {
        $this->isAble('delete', $ticket);

        $ticket->delete();
        return $this->ok('Ticket Deleted Successfully.');
    }
}
