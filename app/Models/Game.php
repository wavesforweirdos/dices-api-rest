<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'dice1',
        'dice2',
        'result',
        'user_id',
    ];

    //relación uno a muchos inversa
    public function player(){
        return $this->belongsTo('App\Models\User');
    }
}
