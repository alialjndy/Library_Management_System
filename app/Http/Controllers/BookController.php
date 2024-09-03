<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Models\Book;
use App\Service\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookService;
    public function __construct(BookService $bookService){
        $this->bookService = $bookService ;
    }
    /**
     * Summary of index
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $book = $this->bookService->filter($request);
        return response()->json([
            'status'=>true ,
            'AllBook'=>$book ,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        $res = $this->bookService->create($request->validated());
        return response()->json([
            'status'=>true ,
            'message'=>'Book added succesffully',
            'data'=>[
                'title'=>$res->title,
                'author'=>$res->author,
                'description'=>$res->description,
                'published_at'=>$res->published_at,
                'rating'=>$res->rating,
                'Available'=>1
            ],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::find($id);
        if($book){
            return response()->json([
                'status'=>'success',
                'data'=>[
                'title'=>$book->title,
                'author'=>$book->author,
                'desciption'=>$book->description,
                'published_at'=>$book->published_at
                ]
            ]);
        }else{
            return response()->json([
                'status'=>'failed',
                'message'=>'book not found ',
            ]);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookUpdateRequest $request, Book $book)
    {
       $validatedData = $request->validated();
       $updatedBook = $this->bookService->update($book , $validatedData);
       return response()->json([
            'status'=>true,
            'data'=>[
                'title'=>$updatedBook->title,
                'author'=>$updatedBook->author,
                'desciption'=>$updatedBook->description,
                'published_at'=>$updatedBook->published_at
            ]
       ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $this->bookService->delete($book->id);
        return response()->json([
            'status'=>true,
            'message'=>'Book deleted successfully'
        ]);
    }
}
