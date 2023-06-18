<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Define the admin routes
Route::namespace('App\Http\Controllers\Admin')->prefix('/admin')->group(function () {
    Route::get('/edit-welcome-page', 'EditWelcomePageController@showEditWelcomePageForm')
        ->name('admin.edit-welcome-page.show');
    Route::delete('/edit-welcome-page', 'EditWelcomePageController@deleteMessage')
        ->name('admin.edit-welcome-page.delete-message');
    Route::put('/edit-welcome-page', 'EditWelcomePageController@updateData')
        ->name('admin.edit-welcome-page.update');
});

Route::namespace('App\Http\Controllers')->prefix('tickets')->group(function () {
    Route::get('/', 'TicketController@showTicketsListPage')
        ->name('tickets.show');
    Route::get('/{ticket}', 'TicketController@showTicketPage')
        ->name('ticket.show');
    Route::delete('/{ticket}', 'TicketController@deleteTicket')
        ->name('ticket.delete');
    Route::post('/', 'TicketController@createTicket')
        ->name('tickets.create');
    Route::post('/{ticket}/comments', 'TicketController@createTicketComment')
        ->name('tickets.comments.create');
    Route::delete('/tickets/comments/{ticketComment}', 'TicketController@deleteTicketComment')
        ->name('tickets.comments.delete');
    Route::patch('/tickets/{ticket}/status', 'TicketController@editTicketStatus')
        ->name('tickets.status');
});

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'welcomeInformations' => \App\Models\WelcomeInformation::cachedFirstEntry(),
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
