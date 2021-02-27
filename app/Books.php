<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    public $timestamps = false;
    protected $table = 'books';
    protected $fillable =
    [
        'isbn',
        'title',
        'cover',
    ];
}
