<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWalletAccount extends Model
{

    protected $table = 'user_wallet_accounts';
    protected $primaryKey = 'User_Wallet_Account_Id';
    public $timestamps = true;
    use HasFactory;
    
    protected $fillable =[
        'Account_Number',
        'Account_Name',
        'User_Profile_Id',
        'Wallet_Id',
        'Status',
    ];

    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class, 'User_Profile_Id');
    }

    public function walletProfile()
    {
        return $this->belongsTo(WalletProfile::class, 'Wallet_Id');
    }
    public function walletStatus()
    {
        return $this->belongsTo(WalletProfile::class, 'Status');
    }
}
