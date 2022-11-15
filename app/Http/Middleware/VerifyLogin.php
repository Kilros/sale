<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginServer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {   
        if(Auth::check()){
            return $next($request);
            // return view('admin',[
            //     'user' => Auth::user(),
            // ]);
        }
        else{
            return redirect('/login');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');

        // if ($request->has('user') && $request->has('password')) {
        //     $request->validate([
        //         'user' => 'required',
        //         'password' => [
        //             'required',
        //             'string',
        //             'min:4',             // must be at least 10 characters in length
        //             'regex:/[a-z]/',      // must contain at least one lowercase letter
        //             'regex:/[A-Z]/',      // must contain at least one uppercase letter
        //             'regex:/[0-9]/',      // must contain at least one digit
        //             'regex:/[@$!%*#?&]/', // must contain a special character
        //         ],
        //     ]);
            
        //     $user = $request->input('user');
        //     $password = $request->input('password');
        //     if ($password==1){
        //         return $next($request);
        //     }
        // }
        // return redirect('/login');
    }
}
