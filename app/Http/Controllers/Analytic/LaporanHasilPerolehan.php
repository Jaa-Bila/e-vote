<?php

namespace App\Http\Controllers\Analytic;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use PDF;

class LaporanHasilPerolehan extends Controller
{
    public function index()
    {
        $candidates = Role::find(3)->users;
        $users = User::all();

        if(count($users) < 2){
            return redirect(route('dashboard'))->withErrors('Silahkan input data pemilih untuk membuka page laporan hasil perolehan.');
        }

        $voters = DB::table('users')
        ->join('user_votes', 'users.id', '=', 'user_votes.user_id')
        ->get();

        $maleUsers = $users->filter(function($user){
            return $user->jenis_kelamin === 'laki-laki';
        })->count();

        $femaleUsers = $users->filter(function($user){
            return $user->jenis_kelamin === 'perempuan';
        })->count();

        $userNotVote = $users->filter(function($user) use ($voters){
            return !$voters->contains(function($vote) use ($user){
                 return $vote->user_id == $user->id;
            });
        })->count();

        $candidateVoters = [];
        foreach($candidates as $candidate){
            $candidateVoter = $voters->filter(function($vote) use ($candidate){
                return $vote->paslon_id === $candidate->id;
            })->count();
            
            array_push($candidateVoters, [
                'name' => $candidate->name,
                'count' => $candidateVoter,
                'presentase' => $candidateVoter / count($voters) * 100 . '%'
            ]);
        }

        return view('laporan_hasil_perolehan.index', [
            'users' => $users,
            'voters' => $voters,
            'maleUsers' => $maleUsers,
            'femaleUsers' => $femaleUsers,
            'userNotVote' => $userNotVote,
            'candidateVoters' => $candidateVoters
        ]);
    }

    public function exportPDF()
    {
        $candidates = Role::find(3)->users;
        $users = User::all();
        $voters = DB::table('users')
        ->join('user_votes', 'users.id', '=', 'user_votes.user_id')
        ->get();

        $maleUsers = $users->filter(function($user){
            return $user->jenis_kelamin === 'laki-laki';
        })->count();

        $femaleUsers = $users->filter(function($user){
            return $user->jenis_kelamin === 'perempuan';
        })->count();

        $userNotVote = $users->filter(function($user) use ($voters){
            return !$voters->contains(function($vote) use ($user){
                 return $vote->user_id == $user->id;
            });
        })->count();

        $candidateVoters = [];
        foreach($candidates as $candidate){
            $candidateVoter = $voters->filter(function($vote) use ($candidate){
                return $vote->paslon_id === $candidate->id;
            })->count();
            
            array_push($candidateVoters, [
                'name' => $candidate->name,
                'count' => $candidateVoter,
                'presentase' => $candidateVoter / count($voters) * 100 . '%'
            ]);
        }

        $pdf = PDF::loadView('laporan_hasil_perolehan.pdf', [
            'users' => $users,
            'voters' => $voters,
            'maleUsers' => $maleUsers,
            'femaleUsers' => $femaleUsers,
            'userNotVote' => $userNotVote,
            'candidateVoters' => $candidateVoters
        ]);
        return $pdf->download('laporan.pdf');
    }
}
