<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::get('login', [ApiController::class, 'index']);

Route::group(['middleware' => 'jwt.auth'], function () {

    /**
     * User routes.
     */

    Route::get('user', [UserController::class, 'index']);
    Route::get('user/{id}', [UserController::class, 'show']);
    Route::post('user', [UserController::class, 'store']);
    Route::put('user', [UserController::class, 'update']);
    Route::delete('user/{id}', [UserController::class, 'destroy']);

    /**
     * Ticket routes.
     */

    Route::get('ticket', [TicketController::class, 'index']);
    Route::get('ticket_available', [TicketController::class, 'availableTickets']);
    Route::put('ticket', [TicketController::class, 'asignTicket']);

    /**
     * Event routes.
     */

    Route::get('event', [EventController::class, 'index']);

});
