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

    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class, 'User_Profile_Id');
    }

    public function notification()
    {
        return $this->hasOne(Notification::class, 'Related_Entity_Id');
    }
}
