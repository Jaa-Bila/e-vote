<?php

namespace App\Http\Controllers\Pemilih;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class PemilihController extends Controller
{
    public function index(Request $request)
    {
        $data = DB::table('users')
            ->join('user_role', 'users.id', '=', 'user_role.user_id')
            ->select('users.*')
            ->where('user_role.role_id', 4)
            ->get();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function($row) {
                    $url = asset($row->foto);
                    return '<img src="'.$url.'" border="0" width="100" class="img-rounded" align="center" />';
                })
                ->addColumn('action', function($row) {
                    $urlShow = route('pemilih.show', $row->id);
                    $urlEdit = route('pemilih.edit', $row->id);
                    $button = '<a href="' . $urlShow . '" class=" badge badge-primary" style="margin-right: 10px">Show</a>';
                    if($row->status === 0){
                        $button = $button . '<a href="#" class=" badge badge-info" id="confirm-user" onclick="confirmUser('. $row->id .')" style="margin-right: 10px">Confirm</a>';
                    }
                    $button = $button .
                    '<a href="#" class="badge_cam badge badge-primary" style="margin-right: 10px" onclick="takeAPhoto(' . $row->id . ')" data-toggle="modal" data-target="#modal-lg" data-backdrop="static"><i class="fa fa-camera" aria-hidden="true"></i>  Camera</a>';
                    if(in_array('ADMIN', Session::get('user_roles'))){
                        $button = $button .
                            '<a href="' . $urlEdit . '" class=" badge badge-warning" style="margin-right: 10px">Edit</a>' .
                            '<a href="#" class=" badge badge-danger" id="delete-user" onclick="deleteUser('. $row->id .')" style="margin-right: 10px">Delete</a>';
                    }

                    return $button;
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        return view('pemilih.index');
    }

    public function show(User $user){
        return view('pemilih.show', ['user' => $user]);
    }

    public function create()
    {
        $user = User::latest()->first();
        return view('pemilih.create', ['user' => $user]);
    }

    public function activate(User $user)
    {
        $user->status = 1;
        $user->save();
        Session::flash('success', 'Berhasil mengkonfirmasi user');
        return response()->json('success');
    }

    public function store(Request $request)
    {
        $latestUser = User::latest()->first();
        $image = $request->file('image');
        $ext = $image->getClientOriginalExtension();
        $imagename = Carbon::now()->format('dmYHis') . '.' . $ext;

        $image->move('storage/image/', $imagename);
        $imagePath = 'storage/image/' . $imagename;

        $user = User::create([
            'name' => $request->name,
            'no_urut' => $latestUser->no_urut + 1,
            'nik' => $request->nik,
            'no_ktp' => $request->no_ktp,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'alamat' => $request->alamat,
            'pekerjaan' => $request->pekerjaan,
            'provinsi' => $request->provinsi,
            'kabkota' => $request->kabkota,
            'kecamatan' => $request->kecamatan,
            'desa_kelurahan' => $request->desa_kelurahan,
            'foto' => $imagePath,
            'status' => 0
        ]);

        $user->roles()->attach([4]);

        return redirect()->route('pemilih.index')->with('success', 'Berhasil menambahkan user');
    }

    public function edit(User $user)
    {
        return view('pemilih.edit', ['user' => $user]);
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
            'no_urut' => $user->no_urut,
            'no_urut_calon' => $user->no_urut_calon,
            'nik' => $request->nik,
            'no_ktp' => $request->no_ktp,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'alamat' => $request->alamat,
            'pekerjaan' => $request->pekerjaan,
            'provinsi' => $request->provinsi,
            'kabkota' => $request->kabkota,
            'kecamatan' => $request->kecamatan,
            'desa_kelurahan' => $request->desa_kelurahan,
        ]);

        return redirect()->route('pemilih.index')->with('success', 'Berhasil memperbarui data user');
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

    public function getUserVote(Request $request)
    {
        $data = DB::table('users')
                ->join('user_votes', 'users.id', '=', 'user_votes.user_id')
                ->select('users.*', 'user_votes.*')
                ->get();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('real_image', function($row){
                    $url = asset($row->foto);
                    return '<img src="'.$url.'" border="0" width="100" class="img-rounded" align="center" />';
                })
                ->editColumn('pengawas_image', function($row){
                    $url = asset($row->foto_pengawas);
                    return '<img src="'.$url.'" border="0" width="100" class="img-rounded" align="center" />';
                })
                ->rawColumns(['real_image', 'pengawas_image'])
                ->make(true);
        }

        return view('pemilih.daftar_sudah_pilih');
    }

    public function getUserNotVote(Request $request)
    {
        $voted = DB::table('users')
            ->join('user_votes', 'users.id', '=', 'user_votes.user_id')
            ->get();

        $users = User::all();
        $data = $users->filter(function($user) use ($voted){
            return !$voted->contains(function($vote) use ($user){
                 return $vote->user_id == $user->id;
            });
        })->reject(function ($user){
            return $user->roles->contains(function ($role){
                return $role->id === 1 || $role->id === 2;
            });
        });

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function($row) {
                    $url = asset($row->foto);
                    return '<img src="'.$url.'" border="0" width="100" class="img-rounded" align="center" />';
                })
                ->rawColumns(['image'])
                ->make(true);
        }

        return view('pemilih.daftar_belum_pilih');
    }

    public function votePage(Request $request)
    {
        if(auth()->user()->foto_pengawas === null)
        {
            auth()->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors(['Anda belum memiliki foto dari pengawas.']);
        }

        $paslon = DB::table('users')
            ->join('user_role', 'users.id', '=', 'user_role.user_id')
            ->where('user_role.role_id', 3)
            ->select('users.*')
            ->get();

        return view('pemilih.vote', ['datas' => $paslon]);
    }

    public function vote(Request $request)
    {
        try{
            $user = User::find(auth()->user()->id);
            $roles = Session::get('user_roles');

            if(count($roles) === 1 && in_array('USER', $roles))
            {
                $user->status = 2;
                $user->save();
            }

            DB::table('user_votes')->insert([
                'user_id' => $user->id,
                'paslon_id' => $request->paslon_id
            ]);

            auth()->logout();

            $request->session()->flash("success","Selamat anda sudah melakukan pemilihan.");

            $request->session()->regenerateToken();
        }catch (\Exception $e){
            return response()->json($e->getMessage());
        }

        return response()->json($request->all());
    }

    public function fotoPengawas(Request $request){
        try{
            $imagename = "pengawas-".Carbon::now()->format('dmyHis') . ".png";
            $imagePath = 'storage/image/' . $imagename;
            $img = str_replace('data:image/png;base64,', '', $request->foto_pengawas);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            file_put_contents(public_path($imagePath), $data);

            DB::table('users')
            ->where('id', $request->user_id)
            ->update([
                'foto_pengawas' => $imagePath
            ]);
        }catch (\Exception $e){
            return response()->json($e->getMessage());
        }

        return response()->json($request->all());
    }

    public function getPaslonVoters(Request $request, $paslon_id){
        $data = User::with('vote')
            ->whereHas('vote', function($query) use ($paslon_id){
                $query->where('paslon_id', $paslon_id);
            })->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('image', function($row){
                $url = asset($row->foto);
                return '<img src="'.$url.'" border="0" width="100" class="img-rounded" align="center" />';
            })
            ->rawColumns(['image'])
            ->make(true);

    }
}
