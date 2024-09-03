<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'book_id',
        'user_id',
        'borrowed_at',
        'due_date',
        'returned_at'
    ];
    public function book(){
        // Each BorrowRecord belongs to one book
        return $this->belongsTo(Book::class);
    }

}
