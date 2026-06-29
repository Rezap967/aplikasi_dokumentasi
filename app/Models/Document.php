<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sprint_id',
        'objective',
        'result',
        'obstacle',
        'solution',
        'next_plan',
    ];

    /**
     * Get the sprint that owns the document.
     */
    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }
}
