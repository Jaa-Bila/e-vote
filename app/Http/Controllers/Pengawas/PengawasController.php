<?php

namespace App\Http\Controllers\Pengawas;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class PengawasController extends Controller
{
    public function index(Request $request)
    {
        $data = DB::table('users')
            ->join('user_role', 'users.id', '=', 'user_role.user_id')
            ->select('users.*')
            ->where('user_role.role_id', 2)->get();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function($row) {
                    $url = asset($row->foto);
                    return '<img src="'.$url.'" border="0" width="100" class="img-rounded" align="center" />';
                })
                ->addColumn('action', function($row) {
                    $urlEdit = route('pengawas.edit', $row->id);
                    $urlApprove = route('pengawas.approve', $row->id);
                    $urlDelete = route('pengawas.destroy', $row->id);
                    $button = '';
                    if($row->status === 0){
                        $button = $button . '<form action="' .  $urlApprove  . '" method="post">' .
                            csrf_field()  .
                            '<button class="btn btn-info" type="submit" onclick="return confirm(' .
                            "'Are you want to approve $row->name ?')" .
                            '" href="' .  $urlApprove  . '">Approve</button>' .
                            '</form>';
                    }
                    $button = $button .
                        '<form action="' .  $urlDelete  . '" method="post">' .
                        '<a href="' . $urlEdit . '" class=" btn btn-primary" style="margin-right: 10px">Edit</a>' .
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

        return view('pengawas.index');
    }

    public function create()
    {
        $user = User::latest()->first();
        return view('pengawas.create', ['user' => $user]);
    }

    public function approve(User $user)
    {
        $user->status = 1;
        $user->save();
        return redirect()->back()->with('success', 'Berhasil mengaktifkan user');
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
            'no_urut' => $latestUser->no_urut,
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

        $user->roles()->attach([2, 4]);

        return redirect()->route('pengawas.index')->with('success', 'Berhasil menambahkan user');
    }

    public function edit(User $user)
    {
        return view('pengawas.edit', ['user' => $user]);
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

        return redirect()->route('pengawas.index')->with('success', 'Berhasil memperbarui data user');
    }

    public function destroy(User $user)
    {
        $user->status = 0;
        $user->save();
        return redirect()->back()->with('success', 'Berhasil menonaktifkan user');
    }
}
