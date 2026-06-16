<?php
namespace App\Services;

use App\Dto\MemberDto;
use App\Models\Member;

class MemberDto_buildService{

    public function build(MemberDto $dto){
        $dto->members = Member::paginate(3);
        return $dto;
}
    
}