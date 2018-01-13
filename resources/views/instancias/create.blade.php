@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            {{ Form::open(['url' => 'instancias']) }}
            <div class="col-md-12">
               <div class="form-group">
                {{ Form::label('nome', 'Nome da instância', ['class' => 'awesome']) }}
                {{ Form::text('nome') }}
               </div>
               <div class="form-group">
                {{ Form::label('email', 'E-mail', ['class' => 'awesome']) }}
                {{ Form::email('email') }}
               </div>
               <div class="form-group">
                {{ Form::label('mensalidade', 'Mensalidade', ['class' => 'awesome']) }}
                {{ Form::number('mensalidade') }}
               </div>
               <div class="form-group">
                {{ Form::label('telefone', 'Telefone', ['class' => 'awesome']) }}
                {{ Form::text('telefone') }}
               </div> 
            </div>
            {{ Form::submit('Criar') }}
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
