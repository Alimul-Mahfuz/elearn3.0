<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table='accounts';
    protected $primaryKey='acc_id';
    public $timestamps=false;
    use HasFactory;

    function authtoken(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Authtoken::class,'acc_id');
    }

    function student(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Student::class,'acc_id');
    }
    function teacher(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Teacher::class,'acc_id');
    }
}
