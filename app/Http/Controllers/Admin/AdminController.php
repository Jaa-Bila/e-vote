<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $data = DB::table('users')
            ->join('user_role', 'users.id', '=', 'user_role.user_id')
            ->select('users.*')
            ->where('user_role.role_id', 1)->get();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function($row) {
                    $url = asset($row->foto);
                    return '<img src="'.$url.'" border="0" width="100" class="img-rounded" align="center" />';
                })
                ->addColumn('action', function($row) {
                    $urlShow = route('admin.show', $row->id);
                    $urlEdit = route('admin.edit', $row->id);
                    $button = '';
                    if($row->status === 0){
                        $button = $button . '<a href="#" class=" badge badge-info" id="confirm-user" onclick="confirmUser('. $row->id .')" style="margin-right: 10px">Confirm</a>';
                    }
                    $button = $button . '<a href="' . $urlShow . '" class=" badge badge-info" style="margin-right: 10px">Show</a>'.
                    '<a href="' . $urlEdit . '" class=" badge badge-primary" style="margin-right: 10px">Edit</a>' .
                    '<a href="#" class=" badge badge-danger" id="delete-user" onclick="deleteUser('. $row->id .')" style="margin-right: 10px">Delete</a>';

                    return $button;
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        return view('admin.index');
    }

    public function show(User $user){
        return view('admin.show', ['user' => $user]);
    }

    public function create()
    {
        $user = User::latest()->first();
        return view('admin.create', ['user' => $user]);
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
            'status' => 1
        ]);

        $user->roles()->attach([1]);

        return redirect()->route('admin.index')->with('success', 'Berhasil menambahkan user');
    }

    public function edit(User $user)
    {
        return view('admin.edit', ['user' => $user]);
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

        return redirect()->route('admin.index')->with('success', 'Berhasil memperbarui data user');
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
