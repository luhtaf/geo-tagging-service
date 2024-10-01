<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenetapanPelaksanaan extends Model
{
    use HasFactory;
	protected $connection = 'pgsql'; // Ganti dengan nama koneksi yang sesuai
	protected $table = 'tbl_penetapan_pelaksanaan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'id', 'penetapan_id', 'permohonan_id', 'tanggal_surat', 'nomor_surat', 'file_surat_id',
        'penjual_hadir', 'cara_penawaran', 'media_pengumuman_id', 'latest', 'prev', 
        'tempat_lelang_id', 'jenis_permohonan_lelang', 'jumlah_pengumuman', 'tanggal_terbit', 
        'tanggal_batas_fisik', 'tanggal_mulai', 'tanggal_selesai', 'created_by', 'updated_by', 
        'deleted_at', 'created_at', 'updated_at', 'file_media'
    ];

    protected $dates = ['deleted_at'];
}
