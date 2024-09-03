<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'author',
        'description',
        'published_at',
        'category',
        'rating'
    ];
    public function ratings()
    {
        return $this->hasMany(Rating::class);
        // Each book have mutliple rating
    }
    public function borrowRecord(){
        //Each book have multiple borrowRecord
        return $this->hasMany(BorrowRecord::class);
    }
}
