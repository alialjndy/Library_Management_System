<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     *
     */
    public function dashboard()
    {
        return response()->json([
            'status' => true,
            'message' => 'Welcome to Admin Dashboard',
            'data' => [
                'users_count' => \App\Models\User::count(),
                'books_count' => \App\Models\Book::count(),

            ],
        ]);
    }
}
