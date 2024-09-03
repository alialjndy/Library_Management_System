<?php
namespace App\Service;

use App\Exceptions\BookNotAvailableException;
use App\Models\Book;
use App\Models\BorrowRecord;
use Tymon\JWTAuth\Facades\JWTAuth;

class BorrowRecordService{
    public function getAllBorrowRecord(){
        $borrowRecord = BorrowRecord::all();
        return $borrowRecord;
    }
    public function create(array $data)
    {
        // Retrieve the book by the provided book_id, throw an error if the book doesn't exist
        $bookForBorrow = Book::findOrFail($data['book_id']);

        // Check if the book is available for borrowing
        if(!$bookForBorrow->available)
        {
            throw new BookNotAvailableException();
        }
        // Retrieve the currently authenticated user's ID from the JWT token
        $user_id = JWTAuth::user()->id ;

        // Assign the current user's ID to the user_id in the input data
        $data['user_id'] = $user_id ;

        // Create a new borrow record using the provided data
        $borrowRecord = BorrowRecord::create($data);
        $borrowRecord->borrowed_at = now();
        $borrowRecord->due_date = now()->addDays(14) ;

         // Find the book by the provided book_id, throw an error if the book doesn't exist
        $book = Book::findOrFail($data['book_id']);
        $book->available = false ;
        $book->save();
        $borrowRecord->save();
        return $borrowRecord ;
    }
    public function update(array $data , string $id){
        $user_id = JWTAuth::user()->id;
        if($user_id === $data['user_id']){
            $borrowRecord = BorrowRecord::findOrFail($id);
            $updatedBorrowRecord = $borrowRecord->update();
            return $updatedBorrowRecord ;

        }else{
            return ;
        }

    }
    public function Delete(string $id){
        if($this->checkUserIsAdmin()){
            $borrowRecord = BorrowRecord::findOrFail($id);
            $res = $borrowRecord->delete();
            return $res ;
        }

    }
    public function checkUserIsAdmin(){
        $user = JWTAuth::parseToken()->authenticate();
        if($user && $user->is_admin){
            return true ;
        }else{
            return false;
        }
    }
}
?>
