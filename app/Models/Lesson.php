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

        $newVideo = [];
        foreach($value as $k=>$v){
            $valueVideo = [];
            if(!empty($v['old_url'])){
                $valueVideo['url'] = $v['old_url'];
            }else{
                $valueVideo['url']=$v['url'];
            }

            if (!empty($v["old_thumbnail"])) {
                $valueVideo["thumbnail"] = $v["old_thumbnail"];
            } else {
                $valueVideo["thumbnail"] = $v["thumbnail"];
            }
            $valueVideo['name']=$v['name'];
            array_push($newVideo,$valueVideo);
        }

        //json_encode makes it json for the database
        //array_values get the values of the php associative array
        $this->attributes['video'] = json_encode(array_values($newVideo));
    }

    public function oldsetVideoAttribute($value){
        //dd($value);
     
    //    dump($value);
    //    exit();
     
        //the below method json_encode converts the object to json from array
        $this->attributes['video'] = json_encode(array_values($value));
    }


    public function getVideoAttribute($value){
        //conver to associative array
        /*
            "key"=>"value",
        */
        $result = json_decode($value, true);
        if(!empty($result)){
            foreach($result as $key => $value){
                $result[$key]['url'] = env('APP_URL')."uploads/".$value['url'];
                $result[$key]['thumbnail'] = env('APP_URL') . "uploads/" . $value['thumbnail'];
            }


        }
         $this->attributes['video']= $result;
         return $result;
    }
    public function oldgetVideoAttribute($value){


        $this->attributes['video'] = array_values(json_decode($value, true)?:[]);
       //dd($this->attributes['video']);
     //  dd($value);
    }
}
    //php artisan make:model Lesson