<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display all events.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Event::all();

        return response()->json([
            "success" => true,
            "message" => "Ticket List",
            "data" => $tickets
        ]);
    }
}
