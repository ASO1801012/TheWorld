<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model{

    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function group(){
        return $this->belongsTo('App\Models\Group');
    }

}