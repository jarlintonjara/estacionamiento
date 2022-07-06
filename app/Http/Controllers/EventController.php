<?php

namespace App\Http\Controllers;
 
use App\Models\{Event, User};
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\URL;

class EventController extends Controller
{
    public function getLinkSubscribe()
    {
        return URL::temporarySignedRoute(
            'event.subscribe',
            now()->addMinutes(5),
            ['event' => Event::first(), 'user' => auth()->user()]
        );
    }

    public function subscribe(Request $request, Event $event, User $user)
    {
        if (!$request->hasValidSignature()) {
            abort(403);
        }

        $event->users()->attach($user);

        return response('Te has suscrito al evento.');
    }   
}
