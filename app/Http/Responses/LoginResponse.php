<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as ContractsLoginResponse;

class LoginResponse implements ContractsLoginResponse{
    public function toResponse($request){
        return redirect()->intended(route('memberIndex'));
    }
}