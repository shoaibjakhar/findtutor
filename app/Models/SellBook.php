<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellBook extends Model
{
    use HasFactory;

     protected $table='sell_book';

    protected $fillable=[

    'user_id',
    'title_of_book',
    'author',
    'isbn',
    'year_published',
    'category',
    'condition_of_book',
    'picture',
];
}
