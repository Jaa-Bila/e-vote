<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ElectionInformation;
use App\Models\Gallery;
use App\Models\LandingCarouselPhoto;
use App\Models\MarqueeText;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class PengaturanWeb extends Controller
{
    public function index()
    {
        return view('pengaturan_web.index');
    }

    public function indexGalleries(Request $request)
    {
        $data = Gallery::all();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    $url = asset($row->path);
                    return '<img src="' . $url . '" border="0" width="100" class="img-rounded" align="center" />';
                })
                ->addColumn('action', function ($row) {
                    $urlDelete = route('pengaturan_web.deleteGallery', $row->id);
                    $button = '<form action="' .  $urlDelete  . '" method="post">' .
                        csrf_field()  . method_field("DELETE")  .
                        '<button class="btn btn-danger" type="submit" onclick="return confirm(' .
                        "'Are you sure delete $row->title ?')" .
                        '" href="' .  $urlDelete  . '">Delete</button>' .
                        '</form>';
                    return $button;
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }
    }

    public function indexLandingCarousel(Request $request)
    {
        $data = LandingCarouselPhoto::all();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    $url = asset($row->path);
                    return '<img src="' . $url . '" border="0" width="100" class="img-rounded" align="center" />';
                })
                ->addColumn('action', function ($row) {
                    $urlDelete = route('pengaturan_web.deleteCarousel', $row->id);
                    $button = '<form action="' .  $urlDelete  . '" method="post">' .
                        csrf_field()  . method_field("DELETE")  .
                        '<button class="btn btn-danger" type="submit" onclick="return confirm(' .
                        "'Are you sure delete this ?')" .
                        '" href="' .  $urlDelete  . '">Delete</button>' .
                        '</form>';
                    return $button;
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }
    }

    public function indexElectionInformation(Request $request)
    {
        $data = ElectionInformation::all();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('informasi', function($row){
                    return Str::limit($row->informasi, 30);
                })
                ->editColumn('panduan', function($row){
                    return Str::limit($row->panduan, 30);
                })
                ->addColumn('action', function ($row) {
                    $urlEdit = route('pengaturan_web.editElectionInformation', $row->id);
                    $button = '<a href="' . $urlEdit . '" class=" btn btn-primary" style="margin-right: 10px">Edit</a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function indexMarquee(Request $request)
    {
        $data = MarqueeText::all();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('text', function($row){
                    return Str::limit($row->text, 30);
                })
                ->addColumn('action', function ($row) {
                    $urlEdit = route('pengaturan_web.editMarquee', $row->id);
                    $urlDelete = route('pengaturan_web.deleteMarquee', $row->id);
                    $button = '<form action="' .  $urlDelete  . '" method="post">' .
                        '<a href="' . $urlEdit . '" class=" btn btn-primary" style="margin-right: 10px">Edit</a>'.
                        csrf_field()  . method_field("DELETE")  .
                        '<button class="btn btn-danger" type="submit" onclick="return confirm(' .
                        "'Are you sure delete this ?')" .
                        '" href="' .  $urlDelete  . '">Delete</button>' .
                        '</form>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function createCarousel()
    {
        return view('pengaturan_web.create_landing_page_carousel');
    }

    public function createGalleries()
    {
        return view('pengaturan_web.create_gallery');
    }

    public function createMarquee()
    {
        return view('pengaturan_web.create_marquee');
    }

    public function storeCarousel(Request $request)
    {
        $image = $request->file('image');
        $ext = $image->getClientOriginalExtension();
        $imagename = 'carousel' . '-' . Carbon::now()->format('dmYHis') . '.' . $ext;

        $image->move('storage/image/', $imagename);
        $imagePath = 'storage/image/' . $imagename;

        LandingCarouselPhoto::create([
            'path' => $imagePath,
            'text' => $request->text
            ]);

        return redirect(route('pengaturan_web.index'))->with('success', 'Berhasil menambahkah foto carousel');
    }

    public function storeMarquee(Request $request)
    {
        $marqueeText = new MarqueeText();
        $marqueeText->text = $request->text;
        $marqueeText->save();

        return redirect(route('pengaturan_web.index'))->with('success', 'Berhasil menambahkan tulisan berjalan');
    }

    public function storeGallery(Request $request)
    {
        $image = $request->file('image');
        $ext = $image->getClientOriginalExtension();
        $imagename = 'gallery' . '-' . Carbon::now()->format('dmYHis') . '.' . $ext;

        $image->move('storage/image/', $imagename);
        $imagePath = 'storage/image/' . $imagename;

        Gallery::create([
            'title' => $request->title,
            'path' => $imagePath
        ]);

        return redirect(route('pengaturan_web.index'))->with('success', 'Berhasil menambahkah foto gallery');
    }

    public function editElectionInformation(ElectionInformation $electionInformation)
    {
        return view('pengaturan_web.edit_informasi_panduan')->with('electionInformation', $electionInformation);
    }

    public function editMarquee(MarqueeText $marqueeText)
    {
        return view('pengaturan_web.edit_marquee')->with('marquee', $marqueeText);
    }

    public function updateElectionInformation(Request $request, ElectionInformation $electionInformation)
    {
        $image = $request->file('image');

        $oldPhoto = explode('storage', $electionInformation->image)[1];

        Storage::delete('/public' . $oldPhoto);

        $extImage = $image->getClientOriginalExtension();
        $imagename = Carbon::now()->format('dmYHis') . '.' . $extImage;

        $image->move('storage/image/', $imagename);

        $imagePath = 'storage/image/' . $imagename;

        $electionInformation->informasi = $request->informasi;
        $electionInformation->panduan = $request->panduan;
        $electionInformation->image = $imagePath;
        $electionInformation->video = $request->video;
        $electionInformation->save();

        return redirect(route('pengaturan_web.index'))->with('success', 'Berhasil mengupdate data informasi pemilihan');
    }

    public function updateMarquee(Request $request, MarqueeText $marqueeText)
    {
        $marqueeText->text = $request->text;
        $marqueeText->save();
        return redirect(route('pengaturan_web.index'))->with('success', 'Berhasil mengupdate tulisan berjalan');
    }

    public function deleteCarousel(LandingCarouselPhoto $landingCarouselPhoto)
    {
        $oldPhoto = explode('storage', $landingCarouselPhoto->path)[1];
        Storage::delete('/public' . $oldPhoto);
        $landingCarouselPhoto->delete();

        return redirect(route('pengaturan_web.index'))->with('success', 'Berhasil menghapus foto pada carousel');
    }

    public function deleteGallery(Gallery $gallery)
    {
        $oldPhoto = explode('storage', $gallery->path)[1];
        Storage::delete('/public' . $oldPhoto);
        $gallery->delete();

        return redirect(route('pengaturan_web.index'))->with('success', 'Berhasil menghapus foto pada gallery');
    }

    public function deleteMarquee(MarqueeText $marqueeText)
    {
        $marqueeText->delete();
        return redirect(route('pengaturan_web.index'))->with('success', 'Berhasil menghapus tulisan berjalan');
    }
}
