<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Winners extends Model
{
    protected $table = 'winners';

    protected $fillable = ['winner_name'];

    public $timestamps = false;
}
