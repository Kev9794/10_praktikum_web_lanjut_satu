<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;

class Mahasiswa_Matakuliah extends Model
{
    use HasFactory;
    protected $table = 'mahasiswa_matakuliah';
    protected $primaryKey = 'id';

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class,'matakuliah_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiwa::class,'mahasiswa_id',);
    }

    public function mhs_matkul()
    {
        return $this->belongsToMany(Mahasiwa::class, Mahasiswa_Matakuliah::class, 'mahasiswa_id', 'matakuliah_id');
    }
}
