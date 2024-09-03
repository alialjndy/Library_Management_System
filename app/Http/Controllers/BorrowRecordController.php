<?php

namespace App\Http\Controllers;

use App\Exceptions\BookNotAvailableException;
use App\Http\Requests\BorrowRecordRequest;
use App\Http\Requests\BorrowRecordUpdateRequest;
use App\Models\BorrowRecord;
use App\Service\BorrowRecordService;
use Illuminate\Http\Request;

class BorrowRecordController extends Controller
{
    protected $borrowRecordService;
    public function __construct(BorrowRecordService $borrowRecordService)
    {
        $this->borrowRecordService = $borrowRecordService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrowRecord = $this->borrowRecordService->getAllBorrowRecord();
        return response()->json([
            'status'=>'success',
            'data'=>$borrowRecord,
        ]) ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BorrowRecordRequest $request)
    {
        try{
            $validationData = $request->validated();
            $borrowRecord = $this->borrowRecordService->create($validationData);

            return response()->json([
                'status'=>'success',
                'message'=>'book borrowed successfully',
                'data'=>[
                    'borrowed_at'=>$borrowRecord->borrowed_at,
                    'due_date'=>$borrowRecord->due_date,
                    'returned_at'=>null
                ]
            ]);
        }catch(BookNotAvailableException $e){
            return response()->json([
                'status'=>'failed',
                'message'=>$e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $borrowRecord = BorrowRecord::findOrFail($id);
        return response()->json([
            'status'=>'success',
            'book_id'=>$borrowRecord->book_id,
            'user_id'=>$borrowRecord->user_id,
            'borrowed_at'=>$borrowRecord->borrowed_at,
            'due_date'=>$borrowRecord->due_date
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BorrowRecordUpdateRequest $request, string $id)
    {
        $validationData = $request->validated();
        $res = $this->borrowRecordService->update($validationData,$id);
        if($res){
            return response()->json([
                'status'=>'success',
                'message'=>'borrow updated successfully',
                'new_data'=>$validationData->returned_at
            ]);
        }else{
            return response()->json([
                'status'=>'failed',
                'message'=>'Error has occured'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($this->borrowRecordService->checkUserIsAdmin()){
            $this->borrowRecordService->Delete($id);
            return response()->json([
                'status'=>true ,
                'message'=>'borrow deleted successfully',
            ],200);
        }else{
            return response()->json([
                'status'=>'failed' ,
                'message'=>'You are not admin',
            ],400);
        }
    }
}
