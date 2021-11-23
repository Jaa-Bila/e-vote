<?php

namespace App\Http\Controllers\Analytic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use DB;

class RekapPerolehanSuara extends Controller
{
    public function index()
    {
        $candidates = Role::find(3)->users;

        $voters = DB::table('users')
            ->join('user_votes', 'users.id', '=', 'user_votes.user_id')
            ->get();

        $countPemilih = DB::table('users')
            ->join('user_role', 'users.id', '=', 'user_role.user_id')
            ->where('user_role.role_id', 4)
            ->get();


        $paslon = [];
            foreach($candidates as $can){
                $paslon[] = $can->name;
            }

        $countPemilihVoted = DB::table('users')
            ->join('user_role', 'users.id', '=', 'user_role.user_id')
            ->join('user_votes', 'users.id', '=', 'user_votes.user_id')
            ->where('user_role.role_id', 4)
            ->count();

            if(count($countPemilih) < 2){
                return redirect(route('dashboard'))->withErrors('Silahkan input data pemilih untuk membuka page rekap perolehan suara.');
            }

        $candidateVoters = [];
        $cansvote = [];
            foreach($candidates as $candidate){
                $candidateVoter = $voters->filter(function($vote) use ($candidate){
                    return $vote->paslon_id === $candidate->id;
                })->count();

                $cansvote[] = $candidateVoter;

                array_push($candidateVoters, [
                    'name' => $candidate->name,
                    'count' => $candidateVoter,
                    'presentase' => count($voters) === 0 ? 0 : $candidateVoter / count($voters) * 100 . '%'

                ]);
            }

        return view('rekap_perolehan.index')->with('data', [
            'desa' => $countPemilih[1]->desa_kelurahan,
            'totalPemilih' => count($countPemilih),
            'totalVoter' => $countPemilihVoted,
            'presentase' => $countPemilihVoted / count($countPemilih) * 100])
            ->with('candidateVoters', $candidateVoters)
            ->with('candidates', $candidates)
            ->with('paslon', $paslon)
            ->with('cansvote', $cansvote);
    }
}
