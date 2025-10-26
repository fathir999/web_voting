<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Eloquent\SoftDeletes;


class Candidate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'photo',
        'vision',
        'mission',
        'vote_count',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ✅ Relasi ke tabel votes (1 kandidat punya banyak vote)
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    // ✅ Relasi ke tabel users (melalui tabel votes)
    public function voters()
    {
        return $this->hasManyThrough(
            User::class,
            Vote::class,
            'candidate_id', // Foreign key di tabel votes
            'id',           // Foreign key di tabel users
            'id',           // Local key di tabel candidates
            'user_id'       // Local key di tabel votes
        );
    }

    // ✅ Dapatkan persentase vote dari total keseluruhan
    public function getVotePercentageAttribute()
    {
        $totalVotes = self::sum('vote_count');
        return $totalVotes > 0
            ? round(($this->vote_count / $totalVotes) * 100, 2)
            : 0;
    }
    public function incrementVote()
    {
        $this->vote_count = $this->vote_count + 1;
        $this->save();
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
