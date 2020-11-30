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
use Illuminate\Support\Facades\DB;

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
        $users = User::all()->reject(function ($user){
            return $user->roles->contains(function ($role){
                return $role->id === 1 || $role->id === 2;
            });
        });

        $voters = DB::table('users')
        ->join('user_votes', 'users.id', '=', 'user_votes.user_id')
        ->get();

        $usersNotVote = $users->filter(function($user) use ($voters){
            return !$voters->contains(function($vote) use ($user){
                 return $vote->user_id == $user->id;
            });
        })->count();

        $candidateVoteCounts = [];
        foreach($candidates as $candidate){
            $candidateVoteCount = $voters->filter(function($vote) use ($candidate){
                return $vote->paslon_id === $candidate->id;
            })->count();

            array_push($candidateVoteCounts, $candidateVoteCount);
        }

        return view('home')->with([
            'users' => $users,
            'candidates' => $candidates,
            'voters' => count($voters),
            'usersNotVotee' => $usersNotVote,
            'candidateVoteCounts' => $candidateVoteCounts
        ]);
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
