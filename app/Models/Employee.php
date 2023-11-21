<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'praesentiert',
        'gekocht',
        'file_name',
        'mime_type',
        'path',
        'disk',
        'file_hash',
        'collection',
        'size',

    ];

    public function dateForNamepraesentiert()
    {
        return $this->hasOne(Date::class, 'namepraesentiertid', 'id');
    }

    public function dateForNamegekocht()
    {
        return $this->hasOne(Date::class, 'namegekochtid', 'id');
    }

}
