<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\Request;
use App\Models\Book;
use Carbon\Carbon;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();

        return response()->json($books);
    }


    /**
     * Search Book List
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function search(Request $request) 
    {
        $search = $request->input('keyword');

        $books = Book::query()
            ->where('title', 'LIKE', "%{$search}%")
            ->orWhere('author', 'LIKE', "%{$search}%")
            ->get();

        return response()->json($books);
    }


    /**
     * Checkout Books
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function checkout(Request $request) {
        $search = $request->input('keyword');

        $books = Book::where(function ($queryBuilder) use ($search) {
            $queryBuilder->where('title', 'like', "%{$search}%")
                         ->orWhere('author', 'like', "%{$search}%");
        })
        ->whereNull('client_id')
        ->whereNull('due_date')
        ->get();

        return response()->json($books);
    }


    /**
     * Returned Book
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function returned($id) {
        $book = Book::findOrFail($id);
        $book->client_id = null;
        $book->due_date = null;
        $book->save();

        return response()->json('Book Returned!');
    }


    /**
     * Borrowed Book
     * @param  [type] $book   [description]
     * @param  [type] $client [description]
     * @return [type]         [description]
     */
    public function borrowed($book, $client)
    {
        $book = Book::findOrFail($book);
        $book->client_id = $client;
        $book->due_date = Carbon::now()->addDay(30);
        $book->save();

        return response()->json('Book Borrowed!');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();

        $book = new Book;
        $book->title = $request->title;
        $book->author = $request->author;
        $book->published_date = $request->published_date;
        $book->save();

        // $dataFormat = strtotime($request->date);

        // $data = [
        //     'date'  =>  $dataFormat,
        //     'utc'   =>  gmdate('Y-m-d\TH:i:sp', $dataFormat),
        // ];

        return response()->json('New Book Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, $id)
    {
        $validated = $request->validated();

        $book = Book::findOrFail($id);
        $book->title = $request->title;
        $book->author = $request->author;
        $book->published_date = $request->published_date;
        $book->save();

        return response()->json('Book Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json('Book Deleted');
    }
}
