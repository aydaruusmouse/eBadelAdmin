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
        'wallet_type',
        'senders_wallet_name',
        'receivers_wallet_name',
        'senders_account_number',
        'receivers_account_number',
        'senders_account_name',
        'receivers_account_name',
        'currencies',
        'swap_fee',
        'excuted_by',
        'amount',
        'debit_message',
        'credit_response',  
        'status',
        // 'reference_id',
        'transaction_id',
    ];
    
    public $incrementing = false;

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
}
