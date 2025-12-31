<?php

use App\Http\Controllers\TicketPdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tickets/{ticket}/pdf', [TicketPdfController::class, 'show'])
    ->middleware(['auth'])
    ->name('tickets.pdf');
