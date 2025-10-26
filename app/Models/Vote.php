<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Candidate;




class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'candidate_id',
        'voted_at'
    ];

    protected $casts = [
        'voted_at' => 'datetime',
    ];

    // Relationship with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with candidate
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
