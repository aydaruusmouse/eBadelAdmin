<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wallets extends Model
{
    use HasFactory;
   

    protected $fillable = [
        'name',
        'wallet_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
