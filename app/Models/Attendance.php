<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model{
    
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function lesson(){
        return $this->belongsTo('App\Models\Lesson');
    }
}