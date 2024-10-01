<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaLelang extends Model
{
    use HasFactory;
	// protected $connection = 'pgsql_3'; // Ganti dengan nama koneksi yang sesuai
	// protected $table = 'pelaksanaan.tbl_peserta_lelang';

	protected $connection = 'pgsql'; // Ganti dengan nama koneksi yang sesuai
	protected $table = 'pelaksanaan.tbl_peserta_lelang';

    protected $fillable = [
        'id', 'lot_lelang_pelaksanaan_id', 'status_id', 'permohonan_id',
        'lot_lelang_id', 'user_id', 'rekening_id', 'nama_bank', 'nomor_rekening',
        'nama_rekening', 'bendahara_verifikasi', 'bendahara_tgl_verifikasi',
        'pelelang_verifikasi', 'pelelang_tgl_verifikasi', 'pin_bidding',
        'setoran_ujl', 'pengembalian_ujl', 'pelunasan', 'pemenang_lelang',
        'total_pembayaran', 'carapenawaran', 'created_by', 'updated_by',
        'deleted_at', 'created_at', 'updated_at', 'nama_peserta', 'email_peserta',
        'hp_peserta', 'status_keikutsertaan', 'nik_peserta', 'alamat', 'kota',
        'provinsi', 'file_ktp', 'ktp_url', 'bank_id', 'bank_rtgs', 'bank_kliring',
        'tgl_batas_akhir_pelunasan', 'npwp_peserta', 'no_kehadiran'
    ];

    protected $dates = ['deleted_at'];
}
