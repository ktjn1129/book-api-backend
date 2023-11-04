<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $book = Book::all();
        return response()->json(
            $book, 200
        );
;    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $book = Book::create($request->all());
        return response()->json(
            $book, 201
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $update = [
            'title' => $request->title,
            'author' => $request->author,
        ];
        $book = Book::where('id', $id)->update($update);
        $books = Book::all();

        if($book) {
            return response()->json(
                $books, 200
            );
        } else {
            return response()->json([
                'message' => 'Book not found',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::where('id', $id)->delete();

        if($book) {
            return response()->json([
                'message' => 'Book deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Book not found'
            ], 404);
        }
    }
}
