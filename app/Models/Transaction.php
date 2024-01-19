<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transaction'; 
    protected $primaryKey = 'id'; 
    
    // protected $primaryKey = 'transaction_id'; // Assuming you are using UUID for 'transaction_id'
    // public $incrementing = false;
    protected $fillable = [
        'sender',
        'recipient',
        'recipient_phone',
        'date',
        'amount',
        'apiResponseMessage',
        'paymentStatus',
        'time',
        'reference_id',
        'transaction_id',
    ];
    
    public $incrementing = false;

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
}
