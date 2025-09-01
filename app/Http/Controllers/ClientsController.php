<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientsController extends Controller
{
    public function index() : View
    {
        $clients = Client::orderBy('created_at', 'DESC')->paginate();

        return view('client.index', compact('clients'));
    }

    public function view(Client $client)
    {
        return view('client.view', compact('client'));
    }
}
