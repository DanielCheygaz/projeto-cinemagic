<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartConfirmationFormRequest;
use App\Models\Ticket; 
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Customer; 

class CartController extends Controller
{
    public function show(): View
    {
        $cart = session('cart', null);
        return view('cart.show', compact('cart'));
    }

    public function addToCart(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'screening_id' => 'required|exists:screenings,id',
            'seat_id' => 'required|exists:seats,id',
            'price' => 'required|numeric|min:0',
        ]);

        // Criar um novo ticket baseado nos dados fornecidos
        $ticket = new Ticket([
            'screening_id' => $validated['screening_id'],
            'seat_id' => $validated['seat_id'],
            'price' => $validated['price'],
            'status' => 'pending',
        ]);

        $cart = session('cart', null);
        if (!$cart) {
            $cart = collect([$ticket]);
            $request->session()->put('cart', $cart);
        } else {
            if ($cart->firstWhere('id', $ticket->id)) {
                $alertType = 'warning';
                $url = route('tickets.show', ['ticket' => $ticket]);
                $htmlMessage = "Ticket <a href='$url'>#{$ticket->id}</a> <strong>\"{$ticket->id}\"</strong> was not added to the cart because it is already there!";
                return back()->with('alert-msg', $htmlMessage)->with('alert-type', $alertType);
            } else {
                $cart->push($ticket);
            }
        }

        $alertType = 'success';
        $url = route('tickets.show', ['ticket' => $ticket]);
        $htmlMessage = "Ticket <a href='$url'>#{$ticket->id}</a> <strong>\"{$ticket->id}\"</strong> was added to the cart.";
        return back()->with('alert-msg', $htmlMessage)->with('alert-type', $alertType);
    }

    public function removeFromCart(Request $request, Ticket $ticket): RedirectResponse
    {
        $url = route('tickets.show', ['ticket' => $ticket]);
        $cart = session('cart', null);
        if (!$cart) {
            $alertType = 'warning';
            $htmlMessage = "ticket <a href='$url'>#{$ticket->id}</a>
                <strong>\"{$ticket->id}\"</strong> was not removed from the cart because cart is empty!";
            return back()
                ->with('alert-msg', $htmlMessage)
                ->with('alert-type', $alertType);
        } else {
            $element = $cart->firstWhere('id', $ticket->id);
            if ($element) {
                $cart->forget($cart->search($element));
                if ($cart->count() == 0) {
                    $request->session()->forget('cart');
                }
                $alertType = 'success';
                $htmlMessage = "ticket <a href='$url'>#{$ticket->id}</a>
                <strong>\"{$ticket->name}\"</strong> was removed from the cart.";
                return back()
                    ->with('alert-msg', $htmlMessage)
                    ->with('alert-type', $alertType);
            } else {
                $alertType = 'warning';
                $htmlMessage = "ticket <a href='$url'>#{$ticket->id}</a>
                <strong>\"{$ticket->name}\"</strong> was not removed from the cart because cart does not include it!";
                return back()
                    ->with('alert-msg', $htmlMessage)
                    ->with('alert-type', $alertType);
            }
        }
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->session()->forget('cart');
        return back()
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Shopping Cart has been cleared');
    }


    public function confirm(CartConfirmationFormRequest $request): RedirectResponse
    {
        $cart = session('cart', null);
        if (!$cart || ($cart->count() == 0)) {
            return back()
                ->with('alert-type', 'danger')
                ->with('alert-msg', "Cart was not confirmed, because cart is empty!");
        } else {
            $customer = Customer::where('id', $request->validated()['costumer_id'])->first();
            if (!$customer) {
                return back()
                    ->with('alert-type', 'danger')
                    ->with('alert-msg', "Customer does not exist on the database!");
            }
            $inserttickets = [];
            $ticketsOfCustomer = $customer->tickets;
            $ignored = 0;
            foreach ($cart as $ticket) {
                $exist = $ticketsOfCustomer->where('id', $ticket->id)->count();
                if ($exist) {
                    $ignored++;
                } else {
                    $inserttickets[$ticket->id] = [
                        "ticket_id" => $ticket->id,
                        "repeating" => 0,
                        "created_at" => now(),
                        "updated_at" => now()
                    ];
                }
            }
            
            $ignoredStr = match($ignored) {
                0 => "",
                1 => "<br>(1 ticket was ignored because customer  already bought it)",
                default => "<br>($ignored tickets were ignored because customer already bought them)"
            };
            $totalInserted = count($inserttickets);
            $totalInsertedStr = match($totalInserted) {
                0 => "",
                1 => "1 ticket registration was added to the customer",
                default => "$totalInserted tickets registrations were added to the customer",

            };
            if ($totalInserted == 0) {
                $request->session()->forget('cart');
                return back()
                    ->with('alert-type', 'danger')
                    ->with('alert-msg', "No registration was added to the customer!$ignoredStr");
            } else {
                DB::transaction(function () use ($customer, $inserttickets) {
                    $customer->tickets()->attach($inserttickets);
                });
                $request->session()->forget('cart');
                if ($ignored == 0) {
                    return redirect()->route('customers.show', ['customer' => $customer])
                        ->with('alert-type', 'success')
                        ->with('alert-msg', "$totalInsertedStr.");
                } else {
                    return redirect()->route('customers.show', ['customer' => $customer])
                        ->with('alert-type', 'warning')
                        ->with('alert-msg', "$totalInsertedStr. $ignoredStr");
                }
            }
        }
    }
}
