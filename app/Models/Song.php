<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $table = 'songs';
    protected $primaryKey = 'song_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'song_name',
        'artist_id',
        'album_id',
        'genre',
        'song_image',
        'song_file',
        'view_count',
        'status',
    ];

    protected $casts = [
        'view_count' => 'integer',
        'status' => 'integer',
    ];
}
