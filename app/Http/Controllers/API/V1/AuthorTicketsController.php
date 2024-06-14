<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Ticket;
use Illuminate\Foundation\Auth\User;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Resources\V1\TicketResource;
use App\Http\Requests\API\V1\StoreTicketRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

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
        $user = User::findOrFail($author_id);

        $model = [
            'title' =>  $request->input('data.attributes.title'),
            'description' =>  $request->input('data.attributes.description'),
            'status' =>  $request->input('data.attributes.status'),
            'user_id' => $user->id,
        ];

        $ticket = Ticket::create($model);
        return new TicketResource($ticket);
    }

    public function destroy($author_id, Ticket $ticket)
    {
        if($ticket->user_id != $author_id) {
            return $this->error('Ticket cannot found.', 404);
        }

        $ticket->delete();
        return $this->ok('Ticket Deleted Successfully.');
    }
}
