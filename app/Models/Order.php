<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'Order_Id';
    public $timestamps = true;
    use HasFactory;
    protected $fillable = [
        'User_Profile_Id',
        'Origin_Wallet',
        'Destination_Wallet',
        'Sender_Account',
        'Recipient_Account',
        'Origin_Currency',
        'Destination_Currency',
        'Amount',
        'Bridge_Fee',
        'Debit_Response',
        'Credit_Response',
        'Status',
        
    ];
    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class, 'User_Profile_Id');
    }

    public function notification()
    {
        return $this->hasOne(Notification::class, 'Related_Entity_Id');
    }
}
