<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function books()
    {
        $books = Book::with(['uploader'])->orderBy('created_at', 'DESC')->paginate(10);
        $data = [
            'title' => 'Books',
            'books' => $books
        ];
        return view('books', $data);
    }
    public function editbook(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:books,id',
            'title' => 'required',
            'cover' => 'image|mimes:jpeg,png,jpg|max:2048',
            'author' => 'required',
            'publisher' => 'required',
            'printing_date' => 'required',
        ]);



        $book = Book::find($request->id);
        $book->title = $request->title;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->printing_date = $request->printing_date;
        if ($request->cover) {
            $cover = $request->file('cover');
            $ext = $cover->getClientOriginalExtension();
            $cover->storeAs('public/cover', Str::slug($request->title) . '.' . $ext);
            $book->cover = Str::slug($request->title) . '.' . $ext;
        }
        $book->save();
        Session::flash('success', 'Updating book successfully!');
        return redirect('/books');
    }
    public function addbook(Request $request)
    {
        Session::flash('modalid', $request->modalid);
        $request->validate([
            'title' => 'required',
            'cover' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'author' => 'required',
            'publisher' => 'required',
            'printing_date' => 'required',
        ]);

        $book = new Book();
        $book->user_id = session('user')->id;
        $book->title = $request->title;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->printing_date = $request->printing_date;
        
        $cover = $request->file('cover');
        $ext = $cover->getClientOriginalExtension();
        $cover->storeAs('public/cover', Str::slug($request->title) . '.' . $ext);
        
        $book->cover = Str::slug($request->title) . '.' . $ext;
        
        $book->save();
        Session::flash('success', 'Adding book successfully!');
        return redirect('/books');
    }

    public function deletebook($id)
    {
        $book = Book::find($id);
        Storage::delete('public/posts/' . $book->cover);
        $book->delete();
        Session::flash('success', 'Deleting book successfully!');
        return redirect('/books');
    }
}
