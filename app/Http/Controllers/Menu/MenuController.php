<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $data = Menu::all();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $urlEdit = route('menu.edit', $row->id);
                    $button = '<a href="' . $urlEdit . '" class=" btn btn-primary" style="margin-right: 10px">Edit</a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('menu.index');
    }

    public function edit(Menu $menu)
    {
        return view('menu.edit', ['menu' => $menu]);
    }


    public function update(Request $request, Menu $menu)
    {
        $menu->name = $request->name;
        $menu->save();

        return redirect()->back()->with('success', 'Berhasil memperbarui nama menu.');
    }
}
