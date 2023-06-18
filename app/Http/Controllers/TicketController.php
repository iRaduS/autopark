<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTicketCommentRequest;
use App\Http\Requests\CreateTicketRequest;
use App\Models\Ticket;
use App\Models\TicketComment;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

final class TicketController extends Controller
{
    public function showTicketsListPage() {
        return Inertia::render('Ticket/TicketsPage', [
            'tickets' => Ticket::paginate(15)
        ]);
    }

    public function showTicketPage(Ticket $ticket) {
        return Inertia::render('Ticket/TicketPage', [
            'ticket' => $ticket,
            'comments' => TicketComment::where('ticket_id', $ticket->id)->orderBy('created_at', 'DESC')->paginate(15)
        ]);
    }

    public function createTicket(CreateTicketRequest $createTicketRequest) {
        try {
            Ticket::create([
                'user_id' => auth()->id(),
                ...$createTicketRequest->only('problem', 'detailed_problem', 'priority')
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }

        return redirect()->back();
    }

    public function deleteTicket(Ticket $ticket) {
        try {
            $ticket->delete();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }

        return redirect()->back();
    }

    public function createTicketComment(Ticket $ticket, CreateTicketCommentRequest $createTicketCommentRequest) {
        try {
            TicketComment::create([
                'ticket_id' => $ticket->id, 'user_id' => auth()->id(),
                ...$createTicketCommentRequest->only('content')
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }

        return redirect()->back();
    }

    public function deleteTicketComment(TicketComment $ticketComment) {
        try {
            $ticketComment->delete();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }

        return redirect()->back();
    }

    public function editTicketStatus(Ticket $ticket) {
        try {
            $ticket->status = !$ticket->status;
            $ticket->save();
        }  catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }

        return redirect()->back();
    }
}
