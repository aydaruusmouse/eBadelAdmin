<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{   
    protected $table = 'notifications';
    protected $primaryKey = 'Notification_Id';
    public $timestamps = true;
    use HasFactory;
}
