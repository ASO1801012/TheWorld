<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model{

    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function language(){
        return $this->belongsTo('App\Models\Language');
    }
    public function timetype(){
        return $this->belongsTo('App\Models\Timetype');
    }

    public function attendances(){
        return $this->hasMany('App\Models\Attendance');
    }

}
