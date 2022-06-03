<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Kelas;
use App\Models\Mahasiswa_Matakuliah;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //fungsi eloquent menampilkan data menggunakan pagination
        //$mahasiswa1 = DB::table('mahasiswa'); // Mengambil semua isi tabel
        $mahasiswa = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('Nim', 'desc')->paginate(3);
        return view('mahasiswa.index', ['mahasiswa' => $mahasiswa,'paginate' => $paginate]);
        // return view('mahasiswa.index', compact('mahasiswa'))->with('i',(request()->input('page',1)-1)*5);
    }
    public function create()
    {
        $kelas = Kelas::all();
        return view('mahasiswa.create',['kelas' => $kelas]);
    }
    public function store(Request $request)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'foto_profil' => 'image',
        ]);
        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->kelas_id = $request->get("Kelas");
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->foto_profil = $request->file('foto_profil')->store('');
        $mahasiswa->save();
        
        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        //fungsi eloquent untuk menambah data dengan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        //fungsi eloquent untuk menambah data
        //Mahasiswa::create($request->all());

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }
    public function show($Nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        // $mahasiswa = Mahasiswa::find($Nim)
        $mahasiswa = Mahasiswa::with('kelas')->where('nim',$Nim)->first();
        return view('mahasiswa.detail', ['Mahasiswa' => $mahasiswa]);
    }
    public function edit($Nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();;
        $kelas = Kelas::all();
        return view('mahasiswa.edit', compact('Mahasiswa','kelas'));
    }
    public function update(Request $request, $Nim)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
        ]);
        $mahasiswa = Mahasiswa::with('kelas')->where('nim',$Nim)->first();
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->kelas_id = $request->get("Kelas");
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');
        
        //fungsi eloquent untuk mengupdate data dengan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        //fungsi eloquent untuk mengupdate data inputan kita
        //Mahasiswa::find($Nim)->update($request->all());
        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Diupdate');
    }
    public function destroy($Nim)
    {
        //fungsi eloquent untuk menghapus data
        Mahasiswa::find($Nim)->delete();
        return redirect()->route('mahasiswa.index')
            -> with('success', 'Mahasiswa Berhasil Dihapus');
    }

    public function cari(Request $request)
    {
        //Menangkap data pencarian
        $cari = $request->cari;

        //Mengambil data dari tabel mahasiswa sesuai dengan pencarian Nama
        $mahasiswa = DB::table('mahasiswa')
        ->where('nama', 'like', "%" . $cari . "%")
        ->paginate(3);

        //Mengirim data mahasiswa ke view index
        return view('mahasiswa.index', ['mahasiswa' => $mahasiswa]);
    }

    public function nilai($id_mahasiswa)
    {
        // Join relasi ke mahasiswa dan mata kuliah
        $mhs = Mahasiswa_MataKuliah::with('matakuliah')->where("mahasiswa_id", $id_mahasiswa)->get();
        $mhs->mahasiswa = Mahasiswa::with('kelas')->where("nim", $id_mahasiswa)->first();
        //dd($mhs[0]);
        // Menampilkan nilai
        return view('mahasiswa.nilai', compact('mhs'));
    }

    public function cetak_khs($id_mahasiswa)
    {
        $mhs = Mahasiswa_MataKuliah::with('matakuliah')->where("mahasiswa_id", $id_mahasiswa)->get();
        $mhs->mahasiswa = Mahasiswa::with('kelas')->where("nim", $id_mahasiswa)->first();
        $pdf = PDF::loadview('mahasiswa.cetak_khs', compact('mhs'));
        return $pdf->stream();
    }
}
