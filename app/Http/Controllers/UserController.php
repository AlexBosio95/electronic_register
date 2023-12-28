<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function giveAccessToRoute(User $user)
    {
        if (Gate::allows('access-route')) {
            $user->givePermissionTo('access-route');
            return redirect()->back()->with('success', 'L\'utente ha ora accesso alla route.');
        } else {
            return redirect()->back()->with('error', 'L\'utente non ha il permesso di accedere alla route.');
        }
    }
}
