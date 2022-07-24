<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function books()
    {
        $books = Book::with(['uploader'])->paginate(10);
        $data = [
            'title' => 'Books',
            'books' => $books
        ];
        return view('books', $data);
    }
}
