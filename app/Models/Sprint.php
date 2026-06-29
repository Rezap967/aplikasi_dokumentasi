<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'start_date',
        'end_date',
        'target',
        'status',
    ];

    /**
     * Get the user that owns the sprint.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the document associated with the sprint.
     */
    public function document()
    {
        return $this->hasOne(Document::class);
    }
}
