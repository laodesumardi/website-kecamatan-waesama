<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PendudukController extends Controller
{
    public function index(Request $request)
    {
        $query = Penduduk::query();
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status_penduduk', $request->status);
        }
        
        $penduduk = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.penduduk.index', compact('penduduk'));
    }
    
    public function create()
    {
        return view('admin.penduduk.create');
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16|unique:penduduk,nik',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string|max:50',
            'pendidikan' => 'required|string|max:100',
            'pekerjaan' => 'required|string|max:100',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'kewarganegaraan' => 'required|in:WNI,WNA',
            'no_kk' => 'required|string|size:16',
            'hubungan_keluarga' => 'required|string|max:50',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'desa_kelurahan' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kabupaten_kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kode_pos' => 'required|string|size:5',
            'status_penduduk' => 'required|in:Tetap,Pindah,Meninggal',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $data = $request->all();
        
        // Convert jenis_kelamin to database enum format
        if ($data['jenis_kelamin'] === 'Laki-laki') {
            $data['jenis_kelamin'] = 'L';
        } elseif ($data['jenis_kelamin'] === 'Perempuan') {
            $data['jenis_kelamin'] = 'P';
        }
        
        Penduduk::create($data);
        
        return redirect()->route('admin.penduduk.index')
            ->with('success', 'Data penduduk berhasil ditambahkan.');
    }
    
    public function show(Penduduk $penduduk)
    {
        return view('admin.penduduk.show', compact('penduduk'));
    }
    
    public function edit(Penduduk $penduduk)
    {
        return view('admin.penduduk.edit', compact('penduduk'));
    }
    
    public function update(Request $request, Penduduk $penduduk)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16|unique:penduduk,nik,' . $penduduk->id,
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string|max:50',
            'pendidikan' => 'required|string|max:100',
            'pekerjaan' => 'required|string|max:100',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'kewarganegaraan' => 'required|in:WNI,WNA',
            'no_kk' => 'required|string|size:16',
            'hubungan_keluarga' => 'required|string|max:50',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'desa_kelurahan' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kabupaten_kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kode_pos' => 'required|string|size:5',
            'status_penduduk' => 'required|in:Tetap,Pindah,Meninggal',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $data = $request->all();
        
        // Convert jenis_kelamin to database enum format
        if ($data['jenis_kelamin'] === 'Laki-laki') {
            $data['jenis_kelamin'] = 'L';
        } elseif ($data['jenis_kelamin'] === 'Perempuan') {
            $data['jenis_kelamin'] = 'P';
        }
        
        $penduduk->update($data);
        
        return redirect()->route('admin.penduduk.index')
            ->with('success', 'Data penduduk berhasil diperbarui.');
    }
    
    public function destroy(Penduduk $penduduk)
    {
        $penduduk->delete();
        
        return redirect()->route('admin.penduduk.index')
            ->with('success', 'Data penduduk berhasil dihapus.');
    }
}