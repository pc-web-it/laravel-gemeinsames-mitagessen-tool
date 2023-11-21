<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Date extends Model
{
    use HasFactory;

    protected $table = 'dates';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'date',
        'namepraesentiert',
        'namegekocht',
        'namepraesentiertid',
        'namegekochtid',
    ];
    
    protected $dates = ['date'];
    
    public function praesentiert(): HasOne
    {
        return $this->hasOne(Employee::class, 'id', 'namepraesentiertid');
    }
    public function gekocht(): HasOne
    {
        return $this->hasOne(Employee::class, 'id', 'namegekochtid');
    } 

    public function employeeForNamepraesentiert()
    {
        return $this->belongsTo(Employee::class, 'namepraesentiertid', 'id');
    }

    public function employeeForNamegekocht()
    {
        return $this->belongsTo(Employee::class, 'namegekochtid', 'id');
    }
}
