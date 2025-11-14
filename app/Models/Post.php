<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['name','active','parrent_id','order'];

    public function parrent(){
        return $this->hasOne(Post::class,'id','parrent_id');
    }
    public function child(){
        return $this->hasMany(Post::class,'parrent_id','id');
    }
}
