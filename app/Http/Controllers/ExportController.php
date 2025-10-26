<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Vote;
use App\Models\User;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function exportExcel()
    {
        $candidates = Candidate::orderBy('vote_count', 'desc')->get();
        $totalVotes = Vote::count();
        
        // Set headers untuk download Excel
        $filename = 'hasil_voting_' . date('Y-m-d_His') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        // Buka output stream
        $output = fopen('php://output', 'w');
        
        // Tulis BOM untuk UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Header CSV
        fputcsv($output, ['LAPORAN HASIL VOTING']);
        fputcsv($output, ['Tanggal Export', date('d-m-Y H:i:s')]);
        fputcsv($output, ['Total Voting', $totalVotes]);
        fputcsv($output, []); // Baris kosong
        
        // Header tabel
        fputcsv($output, ['No', 'Nama Kandidat', 'Jumlah Suara', 'Persentase (%)', 'Peringkat']);
        
        // Data kandidat
        foreach ($candidates as $index => $candidate) {
            fputcsv($output, [
                $index + 1,
                $candidate->name,
                $candidate->vote_count,
                $candidate->vote_percentage,
                $index + 1
            ]);
        }
        
        fputcsv($output, []); // Baris kosong
        fputcsv($output, ['Total', '', $totalVotes, '100%', '']);
        
        fclose($output);
        exit();
    }

    public function exportDetailExcel()
    {
        $votes = Vote::with(['user', 'candidate'])->orderBy('voted_at', 'desc')->get();
        
        $filename = 'detail_voting_' . date('Y-m-d_His') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Header
        fputcsv($output, ['DETAIL DATA VOTING']);
        fputcsv($output, ['Tanggal Export', date('d-m-Y H:i:s')]);
        fputcsv($output, ['Total Data', $votes->count()]);
        fputcsv($output, []);
        
        // Header tabel
        fputcsv($output, ['No', 'Nama Pemilih', 'Email', 'Kandidat Dipilih', 'Waktu Voting']);
        
        // Data voting
        foreach ($votes as $index => $vote) {
            fputcsv($output, [
                $index + 1,
                $vote->user->name,
                $vote->user->email,
                $vote->candidate->name,
                $vote->voted_at->format('d-m-Y H:i:s')
            ]);
        }
        
        fclose($output);
        exit();
    }
}