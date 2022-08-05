<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studentpayment extends Model
{
    protected $primaryKey='paymentid';
    public  $timestamps=false;

    use HasFactory;
    function enroll(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Enroll::class,'paymentid');
    }

}
