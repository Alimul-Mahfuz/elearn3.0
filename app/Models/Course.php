<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $primaryKey='course_id';
    public  $timestamps=false;
    use HasFactory;
    function teacher(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Teacher::class,'t_id');
    }
    function result(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Result::class,'result_id');
    }

}
