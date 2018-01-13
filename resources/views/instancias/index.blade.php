@extends('layouts.layout')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 row">
            <div class="col-md-2 form-group">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_instancia">Adicionar</button>
            </div>
            <div class="col-md-2">
          </div>
        </div>
        <div class="col-md-12">
            <table id="table" class="table table-striped table-bordered col-md-12">
              <thead>
                <tr>
                  <th>Nome da instância</th>
                  <th>E-mail</th>
                  <th>Telefone</th>
                  <th>Mensalidade</th>
                  <th style="width: 155px;">Ações</th>
                </tr>  
              </thead>
              <tbody>
              </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('extra')
<div class="modal fade" id="modal_instancia" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Instância</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="/profile">
          {{ method_field('PUT') }} 
            <input type="hidden" id="token" val="{{ csrf_token() }}">
           <div class="form-group">
  
            {{ Form::label('nome', 'Nome da instância', ['class' => 'awesome']) }}
            {{ Form::text('nome', '', ['class' => 'form-control']) }}
           </div>
           <div class="form-group">
            {{ Form::label('email', 'E-mail', ['class' => 'awesome']) }}
            {{ Form::email('email', '', ['class' => 'form-control']) }}
           </div>
           <div class="form-group">
            {{ Form::label('mensalidade', 'Mensalidade', ['class' => 'awesome']) }}
            {{ Form::number('mensalidade', '', ['class' => 'form-control']) }}
           </div>
           <div class="form-group">
            {{ Form::label('telefone', 'Telefone', ['class' => 'awesome']) }}
            {{ Form::text('telefone', '', ['class' => 'form-control']) }}
           </div> 
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="create_instancia()" data-dismiss="modal">Salvar</button>
      </div>
    </div>
  </div>
</div>

<script>
  var instancias = [];

  $(document).ready(function(){
    listar_instancias();
  });

  function atualizar_instancias() {
    $.ajax({
      url: '/instancias/listar_instancias',
      method: 'GET',
      dataType: 'json',
      success: function(retorno) {
        instancias = [];
        retorno.data.forEach(function(instancia){
          instancias.push(instancia);
        });
      }
    });
  }

  function listar_instancias() {
    $.ajax({
      url: '/instancias/listar_instancias',
      method: 'GET',
      dataType: 'json',
      success: function(retorno) {
        if( retorno.data.length != 0) {
          retorno.data.forEach(function(instancia) {
            adicionar_tabela(instancia);
          });
        }
      }
    });

    atualizar_instancias();
  }

  function create_instancia() {

    $.ajax({
      url: '/instancias',
      method: 'POST',
      dataType: 'json',
      async: false,
      data: {
        '_token': "{{ csrf_token() }}",
        'nome': $('#nome').val(),
        'email': $('#email').val(),
        'mensalidade': $('#mensalidade').val(),
        'telefone': $('#telefone').val()
      },
      success: function(retorno) {
        var instancia = 
          {
            id: retorno.id,
            nome: $('#nome').val(), 
            email: $('#email').val(), 
            telefone: $('#telefone').val(), 
            mensalidade: $('#mensalidade').val()
          };

        adicionar_tabela(instancia);

        swal("Instância cadastrada!", '', "success")
      }
    });

    atualizar_instancias();

  }

  function excluir_instancia(id_instancia) {

    $.ajax({
      url: '/instancias/excluir_instancia',
      type: 'post',
      data: {
        '_token': "{{ csrf_token() }}",
        id_instancia: id_instancia
      },
      dataType: 'json',
      success: function(retorno) {
        $('#table #instancia' + id_instancia).remove();
      }
    });

    atualizar_instancias();
  }

  function excluir_modal_confirmacao(id_instancia) {
    swal({
      title: "Are you sure?",
      text: "Your will not be able to recover this imaginary file!",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes, delete it!",
      closeOnConfirm: false
    },
    function(){
      swal("Deleted!", "Your imaginary file has been deleted.", "success");
      excluir_instancia(id_instancia);
    });
  }

  function adicionar_tabela(instancia) {
    $('#table tbody').append(`
        <tr id="instancia${instancia.id}">
          <td>${instancia.nome}</td>
          <td>${instancia.email}</td>
          <td>${instancia.telefone}</td>
          <td>${instancia.mensalidade}</td>
          <td>
            <button onclick="update_instancia(${instancia.id})" class="btn btn-primary">Editar</button>
            <button onclick="excluir_modal_confirmacao(${instancia.id})" class="btn btn-danger">Excluir</button>
          </td>
        </tr>
    `);
  }

  function update_instancia(id_instancia) {
    var instancia_editar = {};

    instancias.forEach(function(instancia){
      if(instancia.id == id_instancia) {
        instancia_editar = instancia;
      }
    });

    $('#nome').val(instancia_editar.nome);
    $('#email').val(instancia_editar.email);
    $('#mensalidade').val(instancia_editar.mensalidade);
    $('#telefone').val(instancia_editar.telefone);

    $('#modal_instancia').modal('show');
  }

  function update_instancia_ajax() {

    $.ajax({
      url: '/instancias',
      method: 'POST',
      dataType: 'json',
      async: false,
      data: {
        '_token': "{{ csrf_token() }}",
        'nome': $('#nome').val(),
        'email': $('#email').val(),
        'mensalidade': $('#mensalidade').val(),
        'telefone': $('#telefone').val()
      },
      success: function(retorno) {
        var instancia = 
          {
            id: retorno.id,
            nome: $('#nome').val(), 
            email: $('#email').val(), 
            telefone: $('#telefone').val(), 
            mensalidade: $('#mensalidade').val()
          };

        adicionar_tabela(instancia);

        swal("Instância cadastrada!", '', "success")
      }
    });

    atualizar_instancias();
  }

</script>
@endsection