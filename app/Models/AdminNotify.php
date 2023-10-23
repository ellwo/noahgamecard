<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNotify extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'body',
        'link',
        'readed',
        'type'
    ];
}
