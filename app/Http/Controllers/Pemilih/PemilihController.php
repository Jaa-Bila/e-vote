<?php

namespace App\Http\Controllers\Pemilih;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
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
                    $urlEdit = route('pemilih.edit', $row->id);
                    $urlDelete = route('pemilih.destroy', $row->id);
                    $button =
                        '<a href="' . $urlEdit . '" class=" btn btn-primary" style="margin-right: 10px">Edit</a>' .
                        '<form action="' .  $urlDelete  . '" method="post">' .
                        csrf_field()  . method_field("DELETE")  .
                        '<button class="btn btn-danger" type="submit" onclick="return confirm(' .
                        "'Are you sure delete $row->name ?')" .
                        '" href="' .  $urlDelete  . '">Delete</button>' .
                        '</form>';
                    return $button;
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        return view('pemilih.index');
    }

    public function create()
    {
        $user = User::latest()->first();
        return view('pemilih.create', ['user' => $user]);
    }

    public function store(Request $request)
    {
        $image = $request->file('image');
        $ext = $image->getClientOriginalExtension();
        $imagename = Carbon::now()->format('dmYHis') . '.' . $ext;

        $image->move('storage/image/', $imagename);
        $imagePath = 'storage/image/' . $imagename;

        $user = User::create([
            'name' => $request->name,
            'no_urut' => $request->no_urut,
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
            'status' => 1
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
            'no_urut' => $request->no_urut,
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
        $user->status = 0;
        $user->save();
        return redirect()->back()->with('success', 'Berhasil menonaktifkan user');
    }

    public function getUserVote(Request $request)
    {
        $data = DB::table('users')
                ->join('user_votes', 'users.id', '=', 'user_votes.user_id')
                ->get();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function($row) {
                    $url = asset($row->vote_selfie);
                    return '<img src="'.$url.'" border="0" width="100" class="img-rounded" align="center" />';
                })
                ->rawColumns(['image'])
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

    public function votePage()
    {
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
            $imagename = "vote-".Carbon::now()->format('dmyHis  ') . ".png";
            $imagePath = 'storage/image/' . $imagename;
            $img = str_replace('data:image/png;base64,', '', $request->foto_selfie);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            file_put_contents(public_path($imagePath), $data);

            DB::table('user_votes')->insert([
                'user_id' => $request->user_id,
                'paslon_id' => $request->paslon_id,
                'vote_selfie' => $imagePath
            ]);

            auth()->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
        }catch (\Exception $e){
            return response()->json($e->getMessage());
        }

        return response()->json($request->all());
    }

    public function getVoterImage()
    {
        $data = DB::table('user_votes')->where('user_id', auth()->user()->id)->first();
        return view('pemilih.image', ['data' => $data]);
    }
}
