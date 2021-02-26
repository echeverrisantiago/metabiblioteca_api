@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 d-flex flex-column align-items-center">
            <h1>¡Agrega un libro!</h1>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre</label>
                        <input type="text" class="form-control" id="bookname">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Url de imágen</label>
                        <input type="password" class="form-control" id="bookurl">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Autor</label>
                        <select id="author">
                        @foreach($authors as $author)
                        <option value="{{$author['id']}}">{{$author['name']}}</option>
                        @endforeach
</select>
                    </div>
                    <button type="submit" class="btn btn-primary" id="addbook">Añadir libro</button>

        </div>
    </div>
</div>
</div>
</div>
@endsection