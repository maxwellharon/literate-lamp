<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Book;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();

        return response()->json($clients);
    }


    /**
     * Search Client List
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function search(Request $request) 
    {
        $search = $request->input('keyword');

        $clients = Client::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->get();

        return response()->json($clients);
    }



    /**
     * Checkout Clients
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function checkout(Request $request) {
        $search = $request->input('keyword');

        $clients = Client::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->where('status', 1)
            ->get();

        return response()->json($clients);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        $validated = $request->validated();

        $client = new Client;
        $client->name = $request->name;
        $client->email = $request->email;
        $client->card_id = $request->card_id;
        $client->address = $request->address;
        $client->phone_number = $request->phone_number;
        $client->status = $request->status;
        $client->save();

        return response()->json('New Client Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $client = Client::findOrFail($id);
        $books = $client->books;

        return response()->json($books);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, $id)
    {
        $validated = $request->validated();

        $client = Client::findOrFail($id);
        $client->name = $request->name;
        $client->email = $request->email;
        $client->card_id = $request->card_id;
        $client->address = $request->address;
        $client->phone_number = $request->phone_number;
        $client->status = $request->status;
        $client->save();

        return response()->json('Client Edited!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return response()->json('Client Deleted');
    }
}
