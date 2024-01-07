<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;
    protected $table = 'transaction'; 
    protected $fillable = [
        'sender',
        'recipient',
        'recipient_phone',
        'date',
        'time',
        'reference_id',
    ];
}
