<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'identifier'];

    protected $with = ['user'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function saveds(){
        return $this->hasMany(Saved::class);
    }
    public function likes(){
        return $this->hasMany(Like::class);
    }
}
