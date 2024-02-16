<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'user_profiles'; // Specify the table name

    protected $fillable = [
        'Login_Phone',
        'First_Name',
        'Last_Name',
        'Gender',
        'Date_of_Birth',
        'Join_Date',
    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    /**
     * Define the 'transactions' relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // public function transactions()
    // {
    //     return $this->hasMany(Transaction::class, 'user_id');
    //     // return $this->hasMany(Transaction::class);
    // }
    // // public function wallets()
    // // {
    // //     // return $this->hasMany(Wallet::class, 'user_id');
    // //     return $this->hasMany(wallets::class);
    // // }
}
