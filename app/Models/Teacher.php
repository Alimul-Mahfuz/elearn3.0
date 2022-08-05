<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $primaryKey='t_id';
    public $timestamps=false;
    use HasFactory;
    function course(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Course::class,'t_id');
    }
    function account(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->belongsTo(Account::class,'acc_id');
    }
}
