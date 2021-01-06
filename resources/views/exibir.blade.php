@extends('layouts.app')

@section('content')



<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
</style>

<div class="container">
    <div class="row">
                <table id="customers">
                        <tr>
                            <th>Nome</th>
                            <th>Imagem</th>
                            <th>Link</th>
                            <th>Ano</th>
                            <th>Quilômetragem</th>
                            <th>Combustível</th>
                            <th>Câmbio</th>
                            <th>Portas</th>
                            <th>Cor</th>
                            <th>Preço</th>
                            <th></th>
                        </tr>
                        @foreach($registros as $registro)
                            <tr>
                                <td>{{ $registro->nome }}</td>
                                <td><img   width="100" src="{{asset($registro->img)}}"/></td>
                                <td><a target="_blank" href="{{ $registro->link }}">Link</a></td>
                                <td>{{ $registro->ano }}</td>
                                <td>{{ number_format ($registro->km,0,"",".") }} KM</td>
                                <td>{{ $registro->combustivel }}</td>
                                <td>{{ $registro->cambio }}</td>
                                <td>{{ $registro->portas }}</td>
                                <td>{{ $registro->cor }}</td>
                                <td>R$ {{ number_format( $registro->preco,2,",",".") }}</td>
                               <td><button type="button" data-nome="{{ $registro->nome }}" data-href="/deletar/{{ $registro->id }}" class="btn btn-danger" data-toggle="modal" data-target="#modalDelete">
                                Deletar
                                </button></td>
                            </tr>
                        @endforeach
                </table>
    </div>
</div>

    <!-- Modal -->
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDelete" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Alerta!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div id="conteudo" class="modal-body">
            Deseja deletar?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
            <a class="btn btn-primary btn-ok">Sim</a>
        </div>
        </div>
    </div>
    </div>

    <script>
        $('#modalDelete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        $(this).find('#conteudo').text("Deseja deletar o " + $(e.relatedTarget).data('nome') + "?");
         });
    </script>

@endsection
