<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserWalletAccount;

class WalletProfile extends Model
{
    protected $table = 'wallets_profiles';
    protected $primaryKey = 'Wallet_Id';
    // protected $primaryKey = null; // Remove primary key definition
    // public $incrementing = true;
    public $timestamps = true;
    use HasFactory;

    protected $fillable =[
        'Wallet_Name',
        'Wallet_Provider',
        'Wallet_Type',
        'Merchant_Number',
        'Status',
    ];

    public static function boot()
    {
        parent::boot();
    
        static::updated(function ($walletProfile) {
            if ($walletProfile->isDirty('Status')) {
                $walletProfile->userWalletAccounts->each(function ($userWalletAccount) use ($walletProfile) {
                    $userWalletAccount->update(['Status' => $walletProfile->Status]);
                });
            }
        });
    }
    


    public function userWalletAccounts()
    {
        return $this->hasMany(UserWalletAccount::class, 'Wallet_Id');
    }

    public function bridgeFees()
    {
        return $this->hasMany(BridgeFee::class, 'Origin_Wallet');
    }
}
