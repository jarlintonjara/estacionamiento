<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersSedes extends Model
{
    use HasFactory;

    protected $table = 'users_sedes';

    protected $fillable = [
        'id',
        'user_id',
        'sede_id',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sede() {
        return $this->belongsTo(Sede::class, 'sede_id');
    }
}
