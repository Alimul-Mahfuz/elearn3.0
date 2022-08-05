<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table='students';
    protected $primaryKey='student_id';
    public  $timestamps=false;
    use HasFactory;

    function account(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Account::class,'acc_id');
    }
    function enroll(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Enroll::class,'student_id');
    }
    function result(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Result::class,'result_id');
    }
}
