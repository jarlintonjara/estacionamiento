<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstacionamientoModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    //public $timestamps = false;

    protected $table = 'estacionamiento';

    protected $fillable = ['id', 'numero', 'sede_id', 'created_at', 'deleted_at'];

    public function sede() {
        return $this->hasOne(Sede::class, 'id', 'sede_id');
    }
}
