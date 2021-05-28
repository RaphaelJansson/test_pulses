<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dimension extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function questions(){
        return $this->hasMany('App\Models\Models\Question');
    }
}
