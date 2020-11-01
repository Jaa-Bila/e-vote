<?php

namespace App\Http\Controllers\Paslon;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class PaslonController extends Controller
{
    public function index(Request $request)
    {
        $data = DB::table('users')
            ->join('user_role', 'users.id', '=', 'user_role.user_id')
            ->select('users.*')
            ->where('user_role.role_id', 3)->get();

        if(in_array('PASLON', Session::get('user_roles'))){
            $data = DB::table('users')
            ->join('user_role', 'users.id', '=', 'user_role.user_id')
            ->select('users.*')
            ->where(['user_role.role_id' => 3, 'users.id' => auth()->user()->id])->get();
        }


        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function($row) {
                    $url = asset($row->foto);
                    return '<img src="'.$url.'" border="0" width="100" class="img-rounded" align="center" />';
                })
                ->addColumn('ttl', function($row){
                    return $row->tempat_lahir . ', ' . $row->tanggal_lahir;
                })
                ->addColumn('action', function($row) {
                    $urlShow = route('calon.show', $row->id);
                    $urlEdit = route('calon.edit', $row->id);
                    $button = '';
                    if($row->status === 0){
                        $button = $button . '<a href="#" class=" badge badge-info" id="confirm-user" onclick="confirmUser('. $row->id .')" style="margin-right: 10px">Confirm</a>';
                    }
                    $button = $button . '<a href="' . $urlShow . '" class=" badge badge-info" style="margin-right: 10px">Show</a>'.
                    '<a href="' . $urlEdit . '" class=" badge badge-primary" style="margin-right: 10px">Edit</a>';

                    if(in_array('ADMIN', Session::get('user_roles'))){
                        $button = $button . '<a href="#" class=" badge badge-danger" id="delete-user" onclick="deleteUser('. $row->id .')" style="margin-right: 10px">Delete</a>';
                    }

                    return $button;
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        return view('paslon.index');
    }

    public function activate(User $user)
    {
        $user->status = 1;
        $user->save();
        Session::flash('success', 'Berhasil mengkonfirmasi user');
        return response()->json('success');
    }

    public function show(User $user){
        return view('paslon.show', ['user' => $user]);
    }

    public function create()
    {
        $user = User::join('user_role', 'users.id', '=', 'user_role.user_id')
                ->where('user_role.role_id', 3)
                ->select('users.*')
                ->latest()
                ->first();
        $noUrutCalon = isset($user->no_urut_calon) ? $user->no_urut_calon : 0;
        return view('paslon.create', ['noUrutCalon' => $noUrutCalon]);
    }

    public function store(Request $request)
    {
        $latestUser = User::join('user_role', 'users.id', '=', 'user_role.user_id')
                    ->where('user_role.role_id', 3)
                    ->select('users.*')
                    ->latest()
                    ->first();
        $latestNomorUrut = User::latest()->first();
        $image = $request->file('image');
        $ext = $image->getClientOriginalExtension();
        $imagename = Carbon::now()->format('dmYHis') . '.' . $ext;

        $image->move('storage/image/', $imagename);
        $imagePath = 'storage/image/' . $imagename;

        $user = User::create([
            'name' => $request->name,
            'no_urut_calon' => isset($latestUser->no_urut_calon) ? $latestUser->no_urut_calon + 1 : 1,
            'no_urut' => $latestNomorUrut->no_urut + 1,
            'nik' => $request->nik,
            'no_ktp' => $request->no_ktp,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'alamat' => $request->alamat,
            'pekerjaan' => $request->pekerjaan,
            'kecamatan' => $request->kecamatan,
            'desa_kelurahan' => $request->desa_kelurahan,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'pengalaman_organisasi' => $request->pengalaman_organisasi,
            'keterangan_tambahan' => $request->keterangan_tambahan,
            'provinsi' => $request->provinsi,
            'kabkota' => $request->kabkota,
            'foto' => $imagePath,
            'visi_misi' => $request->visi_misi,
            'status' => 1
        ]);

        $user->roles()->attach([3, 4]);

        return redirect()->route('calon.index')->with('success', 'Berhasil menambahkan user');
    }

    public function edit(User $user)
    {
        return view('paslon.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $image = $request->file('image');
        if(!is_null($image)){
            $oldPhoto = explode('storage', $user->foto)[1];
            Storage::delete('/public' . $oldPhoto);
            $ext = $image->getClientOriginalExtension();
            $imagename = Carbon::now()->format('dmYHis') . '.' . $ext;

            $image->move('storage/image/', $imagename);
            $imagePath = 'storage/image/' . $imagename;
            $user->foto = $imagePath;
            $user->save();
        }

        $user->update([
            'name' => $request->name,
            'nik' => $request->nik,
            'no_urut_calon' => $user->no_urut_calon,
            'no_urut' => $user->no_urut,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'alamat' => $request->alamat,
            'pekerjaan' => $request->pekerjaan,
            'kecamatan' => $request->kecamatan,
            'desa_kelurahan' => $request->desa_kelurahan,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'pengalaman_organisasi' => $request->pengalaman_organisasi,
            'keterangan_tambahan' => $request->keterangan_tambahan,
            'visi_misi' => $request->visi_misi,
            'provinsi' => $request->provinsi,
            'kabkota' => $request->kabkota,
        ]);

        return redirect()->route('calon.index')->with('success', 'Berhasil memperbarui data user');
    }

    public function destroy(User $user)
    {
        if($user->id === auth()->user()->id){
            Session::flash('error', 'Anda tidak bisa menonaktifkan diri anda sendiri');
            return response()->json('error');
        }

        $user->delete();
        Session::flash('success', 'Berhasil menghapus user');
        return response()->json('success');
    }
}
