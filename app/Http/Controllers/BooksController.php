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

        return $books;
    }

    public function welcome(){
        return view('welcome');
    }

    public function addBook(){
        $authors = Authors::all();

        return view('add-book',compact('authors'));
    }

    public function store(Request $req){
        $endpoint = "https://openlibrary.org/api/books?bibkeys=ISBN:$req->id&jscmd=data&format=json";
        $isbnP = HTTP::get($endpoint);

        if(!empty($isbnP["ISBN:$req->id"])):
          $isbn = collect(HTTP::get($endpoint)["ISBN:$req->id"]);
        if(!$isbn){
            return 'ISBN no encontrado';
        } else{

        if(isset($isbn['cover'])){
            $book = Books::create([
            'isbn' => $req->id,
            'title' => $isbn['title'],
            'cover' => $isbn['cover']['large']
        ]);
            } else{
                $book = Books::create([
                    'isbn' => $req->id,
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
            return 'ÉXITO';
    }
else:
    return 'ISBN no encontrado';
endif;
}

    public function delete(Request $req){
        $book = Books::where('isbn','=',$req->id)->first();
        if($book):
        $book->delete();
        return $req->id . ' Eliminado con éxito.';
        else:
            return 'ISBN no encontrado';
        endif;

    }

    public static function getBook(Request $req){
      $bookId = Books::where('isbn','=',$req->id)->first();

      if($bookId):
      $book = Books::join('books_authors','books_authors.book','=','books.id')
      ->join('authors','authors.id','=','books_authors.author')
      ->select('books.isbn','books.title','books.cover','authors.name','authors.url')
      ->where('books.id','=',$bookId->id)
      ->first();

        return $book;
      else:
        return 'ISBN no encontrado';
      endif;

    }

}
