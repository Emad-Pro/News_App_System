<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TribeHistory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'event_date',
        'description',
    ];
    // app/Models/TribeHistory.php
public function images()
{
    return $this->hasMany(TribeHistoryImage::class);
}
}