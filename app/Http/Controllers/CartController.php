<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Cart;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add_to_cart(Ticket $ticket, Request $request)
    {
        $user_id = Auth::id();
        $ticket_id = $ticket->id;

        $existing_cart = Cart::where('ticket_id', $ticket_id)
        ->where('user_id', $user_id)
        ->first();


        if($existing_cart == null)
        {
            $request->validate([
                'amount'=> 'required|gte:1|lte:' . $ticket->stock
            ]);
    
            Cart::create([
                'user_id' => $user_id,
                'ticket_id' => $ticket_id,
                'amount' => $request->amount
            ]);
        }
        else
        {
            $request->validate([
                'amount'=> 'required|gte:1|lte:' . ($ticket->stock - $existing_cart->amount)
            ]);

            $existing_cart->update([
                'amount' => $existing_cart->amount + $request->amount
            ]);
        }
        

        return Redirect::route('show_cart');
    }

    public function show_cart()
    {
        $user_id = Auth::id();
        $carts = Cart::where('user_id', $user_id)->get();
        return view('show_cart', compact('carts'));
    }

    public function update_cart(Cart $cart, Request $request)
    {
        $request->validate([
            'amount' => 'required|gte:1|lte:' . $cart->ticket->stock
        ]);

        $cart->update([
            'amount' => $request->amount
        ]);

        return Redirect::route('show_cart');
    }

    public function delete_cart(Cart $cart)
    {
        $cart->delete();
        return Redirect::back();
    }
}
