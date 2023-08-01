<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Date extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'namepraesentiert',
        'namegekocht',
        'namepraesentiertid',
        'namegekochtid',
    ];
    
    public function praesentiert(): HasOne
    {
        return $this->hasOne(Employee::class, 'id', 'namepraesentiertid');
    }
    public function gekocht(): HasOne
    {
        return $this->hasOne(Employee::class, 'id', 'namegekochtid');
    }
}
