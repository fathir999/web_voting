<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    // User has voted for one candidate
    public function votedCandidate()
    {
        return $this->hasOneThrough(
            Candidate::class,
            Vote::class,
            'user_id',      // Foreign key on votes table
            'id',           // Foreign key on candidates table
            'id',           // Local key on users table
            'candidate_id'  // Local key on votes table
        );
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
