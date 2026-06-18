<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as ContractRegisterResponse;

class RegisterResponse implements ContractRegisterResponse
{
    public function toResponse($request)
    {
        return redirect()->route('mainEC');
    }
}
