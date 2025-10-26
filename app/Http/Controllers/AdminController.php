<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Vote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Comment; // pastikan model Comment ada
use App\Exports\CommentsExport;
use Maatwebsite\Excel\Facades\Excel;



class AdminController extends Controller
{
    public function dashboard()
    {
        $totalVotes = Vote::count();
        $totalCandidates = Candidate::count();
        $totalVoters = User::where('has_voted', true)->count();
        $candidates = Candidate::orderBy('vote_count', 'desc')->get();
        $totalComments = Comment::count();

        return view('admin.dashboard', compact('totalVotes', 'totalCandidates', 'totalVoters', 'candidates', 'totalComments'));
    }

    public function candidates()
    {
        $candidates = Candidate::latest()->get();
        return view('admin.candidates.candidates', compact('candidates'));
    }

    public function createCandidate()
    {
        return view('admin.candidates.create-candidate');
    }

    public function storeCandidate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('candidates', 'public');
        }

        Candidate::create($data);

        return redirect()->route('admin.candidates')->with('success', 'Kandidat berhasil ditambahkan');
    }

    public function editCandidate(Candidate $candidate)
    {
        return view('admin.candidates.edit-candidate', compact('candidate'));
    }

    public function updateCandidate(Request $request, Candidate $candidate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            if ($candidate->photo) {
                Storage::disk('public')->delete($candidate->photo);
            }
            $data['photo'] = $request->file('photo')->store('candidates', 'public');
        }

        $candidate->update($data);

        return redirect()->route('admin.candidates')->with('success', 'Kandidat berhasil diupdate');
    }

    public function deleteCandidate(Candidate $candidate)
    {
        $candidate->delete();

        return redirect()->route('admin.candidates')->with('success', 'Kandidat Berhasil Di Buang ke Trash ');
    }

    public function resetVotes()
    {
        Vote::truncate();
        Candidate::query()->update(['vote_count' => 0]);
        User::query()->update(['has_voted' => false]);

        return redirect()->route('admin.dashboard')->with('success', 'Semua vote berhasil direset');
    }

    public function destroy(Candidate $candidate)
    {
        $candidate->delete(); // soft delete
        return redirect()->route('admin.candidates.candidates')
            ->with('success', 'Kandidat Berhasil Di Buang ke Trash   (soft delete).');
    }

    // Optional: lihat semua termasuk yang dihapus
    public function trashed()
    {
        // Ambil semua kandidat yang sudah di-soft delete
        $candidates = Candidate::onlyTrashed()->get();

        // Kirim data ke view
        return view('admin.candidates.trashed', compact('candidates'));
    }
    public function index()
    {
        $candidates = Candidate::all(); // atau Candidate::withTrashed()->get() jika mau lihat yang dihapus
        return view('admin.candidates.candidates', ['candidates' => $candidates]);
    }

    public function restoreCandidate($id)
    {
        $candidate = Candidate::withTrashed()->findOrFail($id); // ambil data termasuk yang soft deleted
        $candidate->restore(); // restore data

        return redirect()->route('admin.candidates.trashed')->with('success', 'Candidate restored successfully.');
    }

    public function forceDeleteCandidate($id)
    {
        // Ambil candidate termasuk yang sudah soft delete
        $candidate = Candidate::withTrashed()->findOrFail($id);

        // Hapus permanen
        $candidate->forceDelete();

        // Redirect ke halaman trashed dengan pesan sukses
        return redirect()->route('admin.candidates.trashed')->with('success', 'Candidate permanently deleted.');
    }
    public function comments()
    {
        // Ambil semua komentar, termasuk data user dan kandidat terkait
        $comments = Comment::with(['user', 'candidate'])->latest()->get();

        // Kirim ke view
        return view('admin.comments.index', compact('comments'));
    }
    public function exportComments()
    {
        return Excel::download(new CommentsExport, 'comments.xlsx');
    }
    public function toggleStatus($id)
    {
        $candidate = Candidate::findOrfail($id);
        $candidate->status = !$candidate->status;//tonggle (true <--> false)

        //jika status berubah menjadi nonaktif,reset suara ke 0
        
        
        $candidate->save();

        $statusMessage = $candidate->status? 'diaktifkan' : 'dinonaktikan';

        return back()->with('success', "status kandidat berhasil di $statusMessage.");
    }
}
