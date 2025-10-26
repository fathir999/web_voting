<?php

namespace App\Exports;

use App\Models\Comment;
use Maatwebsite\Excel\Concerns\FromCollection;

class CommentsExport implements FromCollection
{
    public function collection()
    {
        return Comment::all(); // ambil semua komentar
    }
}
