<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Koordinat extends Model
{
    protected $table = 'permohonan.tbl_barang_koordinat';
    protected $primaryKey = 'koordinat_id';
    public $timestamps = false;
    use HasFactory;
    use HasUuids;
    protected $fillable = [
        'barang_id',
        'latitude',
        'longitude',
        'koordinat_id'
    ];
}
