<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class TicketController extends Controller
{
    public function create_ticket()
    {
        return view('create_ticket');
    }

    public function store_ticket(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'description' => 'required',
            'image' => 'required'
        ]);

        $file = $request->file('image');
        $path = time() . '_' . $request->name . '.' . $file->getClientOriginalExtension();

        Storage::disk('local')->put('public/' . $path, file_get_contents($file));

        Ticket::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $path
        ]);

        return Redirect::route('index_ticket');
    }

    public function index_ticket()
    {
        $tickets = Ticket::all();
        return view('index_ticket', compact('tickets'));

    }

    public function show_ticket(Ticket $ticket)
    {
        return view('show_ticket', compact('ticket'));
    }

    public function edit_ticket(Ticket $ticket)
    {
        return view('edit_ticket', compact('ticket'));
    }
    
    public function update_ticket(Ticket $ticket, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'description' => 'required',
            'image' => 'required'
        ]);

        $file = $request->file('image');
        $path = time() . '_' . $request->name . '.' . $file->getClientOriginalExtension();

        Storage::disk('local')->put('public/' . $path, file_get_contents($file));

        $ticket->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $path
        ]);

        return Redirect::route('show_ticket' , $ticket);
    }

    public function delete_ticket(Ticket $ticket)
    {
        $ticket->delete();
        return Redirect::route('index_ticket');
    }
    
}
