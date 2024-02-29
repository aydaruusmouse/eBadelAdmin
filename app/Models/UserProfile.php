<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class UserProfile extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'user_profiles';
    protected $primaryKey = 'User_Profile_Id';
    protected $guarded = [];
    public $timestamps = true;
    
    protected $fillable = [
        'Login_Phone',
        'First_Name',
        'Last_Name',
        'Date_of_Birth',
        'Gender',
    ];
   
   
    // public function getJWTIdentifier()
    // {
    //     return $this->getKey();
    // }

    // public function getJWTCustomClaims()
    // {
    //     return [];
    // }
    public function userWalletAccounts()
    {
        return $this->hasMany(UserWalletAccount::class, 'User_Profile_Id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'User_Profile_Id');
    }
}
