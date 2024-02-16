<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BridgeFee extends Model
{ 
    protected $table = 'bridge_fee';
    protected $primaryKey = 'Bridge_Fee_Id';
    public $timestamps = true;

    use HasFactory;

    public function originWallet()
    {
        return $this->belongsTo(WalletProfile::class, 'Origin_Wallet');
    }

    public function destinationWallet()
    {
        return $this->belongsTo(WalletProfile::class, 'Destination_Wallet');
    }
}
