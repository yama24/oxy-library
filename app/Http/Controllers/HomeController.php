<?php

namespace App\Http\Controllers;

use App\Models\{Book, User};
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\{Storage, Hash, Session, Url};


class HomeController extends Controller
{
    public function index()
    {
        $books = Book::all();
        $authors = Book::groupBy('author')->select('author')->get();
        $publishers = Book::groupBy('publisher')->select('publisher')->get();
        $users = User::all();
        $data = [
            'title' => 'Dashboard',
            'books' =>count($books),
            'authors' =>count($authors),
            'users' =>count($users),
            'publishers' =>count($publishers),
        ];
        return view('dashboard', $data);
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

    public function users()
    {
        if (session('user')->admin) {
            $users = User::all();
            $data = [
                'title' => 'Users',
                'users' => $users
            ];
            return view('users', $data);
        } else {
            return redirect('/');
        }
    }

    public function adduser(Request $request)
    {
        Session::flash('modalid', $request->modalid);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);

        $password = Str::random(10);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($password);
        $user->save();

        app('App\Http\Controllers\MailController')->index([
            'to' => $request->email,
            'title' => 'Registration Data',
            'page' => 'registration',
            'data' => ['name' => $request->name, 'email' => $request->email, 'password' => $password, 'url' => url('/')]
        ]);
        Session::flash('success', 'Adding user successfully!');
        return redirect('/users');
    }
    public function changestatus($id)
    {
        $user = User::find($id);
        $user->admin = $user->admin ? 0 : 1;
        $user->save();
        Session::flash('success', 'Changing user successfully!');
        return redirect('/users');
    }
    public function deleteuser($id)
    {
        $user = User::find($id);
        $user->delete();
        Session::flash('success', 'Deleting user successfully!');
        return redirect('/users');
    }
}
