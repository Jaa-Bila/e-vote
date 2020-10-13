<?php

namespace App\Http\Controllers;

use App\Models\ElectionInformation;
use App\Models\Gallery;
use App\Models\LandingCarouselPhoto;
use App\Models\MarqueeText;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserVote;
use App\Models\UserRole;
use App\Models\Role;

class HomeController extends Controller
{

    public function index()
    {
        $landingCarousels = LandingCarouselPhoto::all();
        $candidates = Role::find(3)->users;
        $marqueeTexts = MarqueeText::all();
        return view('landing_page')->with([
            'candidates' => $candidates,
            'marqueeTexts' => $marqueeTexts,
            'landingCarousels' => $landingCarousels
        ]);
    }

    public function dashboard()
    {
        $candidates = Role::find(3)->users;
        $total_voters = UserRole::where('role_id', 4)->count();
        $votes = [];
        $candidate_labels = [];
        foreach ($candidates as $candidate) {
            $candidate_vote = UserVote::where('paslon_id', $candidate->id)->count();
            array_push($votes, $candidate_vote);
            array_push($candidate_labels, $candidate->name);
        }
        $voted_voters = array_sum($votes);
        return view('home', compact('candidate_labels', 'votes', 'total_voters', 'voted_voters'));
    }

    public function profile()
    {
        $candidates = Role::find(3)->users;
        return view('profile')->with('candidates', $candidates);
    }

    public function visiMisi()
    {
        $candidates = Role::find(3)->users;
        return view('visi_misi')->with('candidates', $candidates);
    }

    public function informasiPemilihan()
    {
        $electionInformation = ElectionInformation::first();
        return view('informasi_pemilihan')->with('electionInformation', $electionInformation);
    }

    public function panduanMemilih()
    {
        $electionInformation = ElectionInformation::first();
        return view('panduan_memilih')->with('electionInformation', $electionInformation);
    }

    public function jumlahPemilih()
    {
        $usersCount = User::count();
        return view('jumlah_pemilih')->with('usersCount', $usersCount);
    }

    public function galeri()
    {
        $galleries = Gallery::all();
        return view('galeri')->with('galleries', $galleries);
    }
}
