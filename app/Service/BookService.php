<?php
namespace App\Service;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookService
{
    /**
     * Summary of filter
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function filter(Request $request)
    {
        $query = Book::query();

        if ($request->has('author')) {
            $query->where('author', $request->input('author'));
        }

        if ($request->has('category'))
        {
            $query->where('category', $request->input('category'));
        }

        if ($request->has('available'))
        {
            $query->where('available', $request->input('available') == 'true' ? true : false);
        }
        $book = $query->get();
        return $book ;
    }
    /**
     * Summary of create
     * @param array $data
     * @return book
     */
    public function create(array $data)
    {
        $book = Book::create($data);
        return $book ;
    }
    /**
     * Summary of update
     * @param \App\Models\Book $book
     * @param array $data
     * @return Book
     */
    public function update(Book $book ,array $data)
    {
        $book->update($data);
        return $book ;

    }
    /**
     * Summary of delete
     * @param mixed $id
     * @return mixed
     */
    public function delete($id)
    {
        $book = Book::findOrFail($id);
        return $book->delete();
    }
}
?>
