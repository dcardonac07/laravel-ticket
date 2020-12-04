<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    /**
     * Display all tickets.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::all();

        return response()->json([
            "success" => true,
            "message" => "Ticket List",
            "data" => $tickets
        ]);
    }

    /**
     * Search for tickets that have not yet been assigned.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function availableTickets()
    {
        $tickets = Ticket::all()->whereNull('user_id');

        return response()->json([
            "success" => true,
            "message" => "Ticket List",
            "data" => $tickets
        ]);
    }

    /**
     * Look for the availability of a ticket according to the event id
     * and if it is available assigns it and decreases the remaining tickets
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function asignTicket(Request $request)
    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'event_id' => 'required',
            'number' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Validation Error.",
                "error" => $validator->errors(),
            ], 400);
        }

        $ticket = Ticket::all()->where('number', $input['number'])->where('event_id', $input['event_id'])->pluck('user_id');
        $user = false;

        try {
            if (is_null($ticket[0])) {
                $user = User::firstWhere('email', $input['email']);
            }

            if ($user) {
                DB::table('tickets')
                    ->where('event_id', (int) $input['event_id'])
                    ->where('number', (int) $input['number'])
                    ->update(['user_id' => (int) $user['id']]);

                DB::table('events')->decrement('remaining');

                return response()->json([
                    "success" => true,
                    "message" => "Ticket assigned successfully",
                ]);

            } else {
                return response()->json([
                    "success" => false,
                    "message" => "The ticket is no longer available",
                ], 400);
            }

            return response()->json([
                "success" => true,
                "message" => "Ticket List",
                "data" => $ticket
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "The ticket is no longer available",
            ], 400);
        }
    }
}
