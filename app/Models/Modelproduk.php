<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelproduk extends Model
{
    use HasFactory;
    protected $fillable = [
        'product', 'kategori', 'kemasan'
    ];
}
