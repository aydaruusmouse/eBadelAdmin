<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cross_transfer_model extends Model
{
    use HasFactory;
    protected $table = ['cross_transfer_request'];
    protected $fillable = [
        'sender_wallet_number',
        'receiver_wallet_number', 
        'amount',
        'status',
    ];
}
