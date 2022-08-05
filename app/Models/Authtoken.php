<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authtoken extends Model
{
    /**
     * @var mixed|string
     */

    protected $table='authtokens';
    protected $primaryKey='acc_id';
    public $timestamps=false;
    use HasFactory;

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class,'acc_id');
    }
}
