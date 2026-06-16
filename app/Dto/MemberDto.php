<?php
namespace App\Dto;

class MemberDto{


public $members;

 public function __construct() {}


 public function toViewData(){
    return
    [
        'members' => $this->members,
    ];
 }

}