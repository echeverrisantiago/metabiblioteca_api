<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authors extends Model
{
    public $timestamps = false;
    protected $table = 'authors';
    protected $fillable =
    [
        'name',
        'url'
    ];
}
