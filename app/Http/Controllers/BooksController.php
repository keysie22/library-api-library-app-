<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;
use Exception;

class BooksController extends Controller
{
    /**
     * Get all books
     */
    public function index()
    {
        try {
            $books = Books::all();
            return response()->json($books, 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error fetching books',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new book
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'year' => 'required|integer|min:1000|max:' . date('Y')
            ]);

            $book = Books::create($validated);

            return response()->json($book, 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error creating book',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Retrieve a single book by ID
     */
    public function show($id)
    {
        try {
            $book = Books::find($id);

            if (!$book) {
                return response()->json([
                    'message' => 'Book not found'
                ], 404);
            }

            return response()->json($book, 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error fetching book',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update an existing book
     */
    public function update(Request $request, $id)
    {
        try {
            $book = Books::find($id);

            if (!$book) {
                return response()->json([
                    'message' => 'Book not found'
                ], 404);
            }

            $validated = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'author' => 'sometimes|required|string|max:255',
                'year' => 'sometimes|required|integer|min:1000|max:' . date('Y')
            ]);

            $book->update($validated);

            return response()->json($book, 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error updating book',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a book by ID
     */
    public function destroy($id)
    {
        try {
            $book = Books::find($id);

            if (!$book) {
                return response()->json([
                    'message' => 'Book not found'
                ], 404);
            }

            $book->delete();

            return response()->json([
                'message' => 'Book deleted successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error deleting book',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}