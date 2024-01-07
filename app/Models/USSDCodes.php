<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class USSDCodes extends Model
{
    use HasFactory;
    protected $table = 'u_s_s_d_codes'; // Ensure this matches your table name
    protected $fillable = ['telesom_code', 'somtel_code'];
}
