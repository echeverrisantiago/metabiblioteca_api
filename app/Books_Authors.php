<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books_Authors extends Model
{
    public $timestamps = false;
    protected $table = 'books_authors';
    protected $fillable =
    [
        'book',
        'author'
    ];
}
