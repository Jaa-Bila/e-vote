<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserVote;
use App\Models\UserRole;
use App\Models\Role;

class HomeController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    public function index()
    {
        $candidates = Role::find(3)->users;
        $total_voters = UserRole::where('role_id',4)->count();
        $votes = [];
        $candidate_labels = [];
        foreach ($candidates as $candidate) {
            $candidate_vote = UserVote::where('paslon_id',$candidate->id)->count();
            array_push($votes, $candidate_vote);
            array_push($candidate_labels, $candidate->name);
        }
        $voted_voters = array_sum($votes);
        return view('home', compact('candidate_labels','votes','total_voters', 'voted_voters'));
    }
}
