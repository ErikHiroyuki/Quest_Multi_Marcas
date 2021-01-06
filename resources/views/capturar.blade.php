@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>

* {
  box-sizing: border-box;
}

form.example input[type=text] {
  padding: 10px;
  font-size: 17px;
  border: 1px solid grey;
  float: left;
  width: 80%;
  background: #f1f1f1;
}

form.example button {
  float: left;
  width: 20%;
  padding: 10px;
  background: #2196F3;
  color: white;
  font-size: 17px;
  border: 1px solid grey;
  border-left: none;
  cursor: pointer;
}

form.example button:hover {
  background: #0b7dda;
}

form.example::after {
  content: "";
  clear: both;
  display: table;
}

div.panel-body{
    text-align: center
}
</style>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Quest-Multi-Marcas</div>
                   
                <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/capturar') }}">
                        {{ csrf_field() }}

                        <form class="example" style="margin:auto;max-width:300px">
                            <input id="busca" type="text" placeholder="Search.." name="busca">
                            <button class="btn btn-primary" onclick="document.location.href='/exibir'" type="submit" required autofocus><i class="fa fa-search"></i></button>
                        </form>

                        @if ($artigos)
                                    <span class="help-block">
                                        <strong>Foram encontrados {{ $artigos }} artigos</strong><br>
                                        <button onclick="document.location.href='/exibir';"  class="btn btn-success">Exibir Artigos</button>
                                    </span>
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
