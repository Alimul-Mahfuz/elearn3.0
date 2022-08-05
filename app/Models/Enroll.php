<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enroll extends Model
{
    protected $primaryKey='enroll_id';
    public $timestamps=false;
    use HasFactory;
    function studentpayment(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Studentpayment::class,'paymentid');
    }
    function student(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Student::class,'student_id');
    }
}
