<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FCMNotification extends Model
{
    use HasFactory;

    protected $table = 'fcm_tokens';

    protected $fillable = [
        'user_id', 'token',
    ];
}
