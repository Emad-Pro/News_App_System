<?php

namespace App\Models;

// You need to add this line to tell PHP where to find the HasFactory trait
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TribeHistoryImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'tribe_history_id',
        'path',
    ];
}