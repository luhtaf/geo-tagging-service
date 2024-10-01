<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\FileRepository;
use App\Repositories\GantiPelelangRepository;
use Illuminate\Http\Request;
use App\Models\Alasan;
use App\Models\Permohonan;
use App\Models\Petugas;
use App\Models\Role;



class NewController extends Controller
{
    public function index(){
        return 'Hello From Notifikasi Whatsapp Service';
    }
}
