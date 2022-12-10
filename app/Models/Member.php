<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['nama','parent_id','status'];

    public function childs() {
        return $this->hasMany('App\Models\Member','parent_id','id') ;
   }
}
