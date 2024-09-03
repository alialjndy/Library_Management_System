<?php
namespace App\Service;

use App\Models\Book;
use App\Models\Rating;
use Illuminate\Support\Facades\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class RatingService
{
    /**
     * Summary of getAllRating
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRating()
    {
        $rating = Rating::all();
        return $rating;
    }
    /**
     * Summary of create
     * @param array $data
     * @return Rating
     */
    public function create(array $data)
    {
        $user_id = $this->getUserId();
        $data['user_id'] = $user_id ;
        $rating = Rating::create($data);
        $book = Book::findOrFail($data['book_id']);
        $averageRating = Rating::where('book_id', $data['book_id'])->avg('rating');
        $book->rating = $averageRating;
        $book->save();
        return $rating;
    }
    /**
     * Summary of show
     * @param string $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function show(string $id)
    {
        $rating = Rating::findOrFail($id);
        return $rating;
    }
    /**
     * Summary of update
     * @param array $data
     * @param string $id
     * @return mixed
     */
    public function update(array $data , string $id)
    {
        $user_id = $this->getUserId();
        $data['user_id'] = $user_id;
        $rating = Rating::findOrFail($id);
        if($rating->user_id === $user_id)
        {
            $updatedRating = $rating->update($data);
            return $updatedRating;
        }
        return false;
    }
    /**
     * Summary of Delete
     * @param string $id
     * @return void
     */
    public function Delete(string $id)
    {
        $rating = Rating::findOrFail($id);
        if($this->getUserId() !== $rating->user_id){
            return ;
        }else{
            $res = $rating->delete();
            return $res ;
        }

    }
    /**
     * Summary of getUserId
     * @return mixed
     */
    public function getUserId(){
        $user_id = JWTAuth::user()->id ;
        return $user_id;
    }
}
?>
