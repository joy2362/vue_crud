<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class userInfo extends Model
{
    use  HasFactory,SoftDeletes;

    protected $guarded=[];

    protected $with=['skills'];

    protected $appends=['img','skill'];

    public function getImgAttribute(){
        return env('APP_URL', 'http://localhost') . "/storage/".$this->image;
    }

    public function getSkillAttribute(){
        return  $this->skills()->pluck('skill')->toArray();
    }


    public function skills(){
        return $this->hasMany(userSkill::class);
    }

}
