@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if(count($books) < 1) <div class="container">
                        <div class="row d-flex flex-column align-items-center">
                            <p>Vaya, parece que no tienes libros ¿Deseas agregar unos cuantos?</p>
                            <div class="d-flex">
                                <button class="btn btn-success m-2" id="addSamples">Añadir muestras</button>
                                <a href="addBook">
                                    <button class="btn btn-info m-2" style="color:white;">Añadir libro</button>
                                </a>
                            </div>
                        </div>
                </div>
                @else
                <a href="addBook">
                                    <button class="btn btn-info m-2" style="color:white;">Añadir libro</button>
                                </a>
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <tbody>
                        <thead>
                            <tr>
                                <th>Nombre del libro</th>
                                <th>Portada</th>
                                <th>Autor(es)</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        @foreach($books as $book)
                        <tr class="book-wrapper" id="book-{{$book['id']}}">
                            <td>{{$book['title']}}</td>
                            <td><img src="{{$book['cover']}}" class="cover-book"></td>

                            <td> @foreach($authors as $author)
                                @if($author['id'] == $book['id'])
                                <p> {{$author['name']}}</p>
                                @endif
                                @endforeach
                            </td>

                            <td>
                                <a href="libro/{{$book['id']}}">
                                    <button class="btn btn-primary"><i class="fa fa-eye"></i></button>
                                </a>
                                <a class="delete-book" data-id="{{$book['id']}}">
                                    <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $books->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
</div>
@endsection