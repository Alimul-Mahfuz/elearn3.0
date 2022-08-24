<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apply extends Model
{
    protected $primaryKey='apply_id';
    public $timestamps=false;
    use HasFactory;
}
