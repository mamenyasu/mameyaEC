<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashBoredController extends Controller
{
    public function storeMember(Formrequest $request, DTO $dto, StoreMemberService $storeService){
        $storeService->store($request);
        return view('dashbored',$dto->toViewData());
    }
}
