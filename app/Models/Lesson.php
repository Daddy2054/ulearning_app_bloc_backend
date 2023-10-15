<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    use DefaultDatetimeFormat;
    
    
    protected $casts = [
        'video'=>'json'
    ];

    public function setVideoAttribute($value){
        //the below method json_encode converts the object to json from array
        $this->attributes['video'] = json_encode(array_values($value));
    }

    public function getVideoAttribute($value){


        $this->attributes['video'] = array_values(json_decode($value, true)?:[]);
     //   dd($this->attributes['video']);
    }
}
    //php artisan make:model Lesson