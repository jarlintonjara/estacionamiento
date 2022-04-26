<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingModel extends Model
{
    use HasFactory;

    protected $table = 'setting';

    protected $fillable = [
        'id',
        'time',
        'email',
        'email1',
        'email2',
        'email3',
        'email4',
        'status'
    ];
}
