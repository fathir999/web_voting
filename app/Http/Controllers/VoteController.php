<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Vote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    public function index()
    {
        $candidates = Candidate::where('status', true)->get();
        $hasVoted = Auth::user()->has_voted;
        $userVote = null;

        if ($hasVoted) {
            $userVote = Vote::where('user_id', Auth::id())
                ->with('candidate')
                ->first();
        }

        return view('user.vote', compact('candidates', 'hasVoted', 'userVote'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
             'message' => 'nullable|string|max:500', // tambahkan ini
        ]);

        // Cegah user yang sudah voting
        if (Auth::user()->has_voted) {
            return back()->with('error', 'Anda sudah melakukan voting');
        }

        // Jalankan dalam transaksi database
        DB::transaction(function () use ($request) {
            // Simpan data voting
            Vote::create([
                'user_id' => Auth::id(),
                'candidate_id' => $request->candidate_id,
                'voted_at' => now(),
            ]);

            // Tambah jumlah suara kandidat
            $candidate = Candidate::find($request->candidate_id);
            if ($candidate) {
                $candidate->incrementVote();
            }

            // Update status user jadi sudah voting
            User::where('id', Auth::id())->update(['has_voted' => true]);
        });

        return redirect()
            ->route('user.vote')
            ->with('success', 'Vote berhasil! Terima kasih atas partisipasi Anda.');
    }

    public function results()
    {
        $candidates = Candidate::orderBy('vote_count', 'desc')->get();
        $totalVotes = Vote::count();

        return view('user.results', compact('candidates', 'totalVotes'));
    }
    
}
