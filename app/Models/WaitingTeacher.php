<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaitingTeacher extends Model
{
    use HasFactory;
    protected $table = 'waitingteacher';
    protected $primaryKey = 'wt_id';
    public $timestamps = false;
}
