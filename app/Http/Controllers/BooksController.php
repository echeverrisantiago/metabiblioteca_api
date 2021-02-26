<?php

namespace App\Http\Controllers;
/* SELECT books.*,authors.name FROM `books`,books_authors,authors WHERE books_authors.book = books.id */
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Books;
use App\Authors;
use Illuminate\Support\Facades\HTTP;
use App\Books_Authors;

class BooksController extends Controller
{
    public static function index(){

        $books = Books::paginate(3);

        if(count($books) > 0){

            $authors = Books::join('books_authors','books_authors.book','=','books.id')
            ->join('authors','authors.id','=','books_authors.author')
            ->select('authors.name','authors.url','books.id')
            ->get();

        } else{
            $authors = '';
        }

        return view('home',compact('books','authors'));
    }

    public function welcome(){
        return view('welcome');
    }

    public function addBook(){
        $authors = Authors::all();

        return view('add-book',compact('authors'));
    }

    public function store(Request $req){
        $book = Books::create($req->all());

        $author = Books_Authors::create([
            'book' => $book->id,
            'author' => $req->author
        ]);
        return json_encode($book);
    }

    public function delete(Request $req){
        $book = Books::findOrFail($req->id)->delete();
        return $book;

    }

    public static function getBook(Request $req){
        $book = Books::join('books_authors','books_authors.book','=','books.id')
        ->join('authors','authors.id','=','books_authors.author')
        ->where('books.id','=',$req->id)
        ->first();

        $authors = Books::join('books_authors','books_authors.book','=','books.id')
        ->join('authors','authors.id','=','books_authors.author')
        ->select('authors.name','authors.url')
        ->where('books.id','=',$req->id)
        ->get();



        return view('libro',compact('book','authors'));
    }

    public static function getProductInfo(Request $req){
        $product = Books::where('product_id',$req->id)
        ->orderBy('row_number','asc')->get();
        if(!$product){
            return false;
        } else {
            return $product;
        }
    }

    public function addSamples(){
        $isbn_list = [
            '0120121123',
            '0760054487',
            '0760034400',
            '0619101857',
            '0760057591',
            '1305656288',
            '0760070873',
            '0619057009',
            '0760071071',
            '9781285077307'];

            foreach($isbn_list as $data):
        $endpoint = "https://openlibrary.org/api/books?bibkeys=ISBN:$data&jscmd=data&format=json";
        $isbn = collect(HTTP::get($endpoint)["ISBN:$data"]);

        if(isset($isbn['cover'])){
            $book = Books::create([
            'title' => $isbn['title'],
            'cover' => $isbn['cover']['large']
        ]);
            } else{
                $book = Books::create([
                    'title' => $isbn['title'],
                    'cover' => 'Imagen no definida'
                ]);
            }

            if(isset($isbn['authors'])){
        foreach ($isbn['authors'] as $i => $authores):
            $authorVerify = Authors::where('name','=',$isbn['authors'][$i]['name'])->first();

            if($authorVerify != null){
            $author = $authorVerify;
        } else{

            $author = Authors::create([
                'name' => $isbn['authors'][$i]['name'],
                'url' => $isbn['authors'][$i]['url']
            ]);
        }
        $author_books = Books_Authors::create([
            'book' => $book->id,
            'author' => $author->id
        ]);
        endforeach;
            } else {
                $author = Authors::create([
                    'name' => 'Author no definido',
                    'url' => 'Undefined'
                ]);

        $author_books = Books_Authors::create([
            'book' => $book->id,
            'author' => $author->id
        ]);
    }





            endforeach;
            return 1;


    }

}
