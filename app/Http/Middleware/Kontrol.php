<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserPermissions;
use App\Models\Users;

class Kontrol
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
        if ($request->session()->exists('userData')) {

            $durum = Users::Where('id', $request->session()->get('userData')->id)->first();
            if ($durum->is_active == 0) {
                session()->flash('error', 'Hesabınız Pasif Durumdadır.');
                return redirect('login');
            }
            // izinler alınıyor
            $izinler = UserPermissions::Where('user_id', $request->session()->get('userData')->id)
                ->join('permissions', 'user_permissions.permission_id', '=', 'permissions.id')
                ->select('user_permissions.*', 'permissions.name')
                ->get();
            $request->session()->put('izinler', $izinler);


            return $next($request);
        } else {
            return redirect('login');
        }
    }
}
