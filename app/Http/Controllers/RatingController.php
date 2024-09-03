<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingRequest;
use App\Models\Rating;
use App\Service\RatingService;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    protected $ratingService;
    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }
    /**
     * Summary of index
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $rating = $this->ratingService->getAllRating();
        return response()->json([
            'status'=>'success',
            'data'=>$rating
        ]);
    }

    /**
     * Summary of store
     * @param \App\Http\Requests\RatingRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(RatingRequest $request)
    {
        $validationData = $request->validated();
        $this->ratingService->create($validationData);
        return response()->json([
            'status'=>'success',
            'message'=>'Rating created successfully',
            'data'=>$validationData
        ]);
    }

    /**
     * Summary of show
     * @param string $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        $rating = $this->ratingService->show($id);
        return response()->json([
            'status'=>'success',
            'data'=>$rating
        ]);
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\RatingRequest $request
     * @param string $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(RatingRequest $request, string $id)
    {
        $validationData = $request->validated();
        $updatedRating = $this->ratingService->update($validationData , $id);
        if($updatedRating){
            return response()->json([
                'status'=>'success',
                'message'=>'Rating updated successfully',
                'data'=>[
                    'user_id'=>$validationData['user_id'],
                    'book_id'=>$validationData['book_id'],
                    'rating'=>$validationData['rating']
                ]
            ]);
        }else{
            return response()->json([
                'status'=>'failed',
                'message'=>'You Cant updated this rating because you are not who create this rating'
            ]);
        }
    }

    /**
     * Summary of destroy
     * @param string $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        if($this->ratingService->Delete($id)){
            return response()->json([
                'status'=>'success',
                'message'=>'Rating deleted successfully'
            ]);
        }
        return response()->json([
            'status'=>'failed',
            'message'=>'you cant delete this rating'
        ]);


    }
}
