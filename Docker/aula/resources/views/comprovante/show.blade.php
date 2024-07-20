@extends('templates/main', ['titulo'=>"DETALHES DO COMPROVANTE"])

@section('conteudo')

    <form action="{{ route('comprovante.store') }}" method="GET">
        @csrf
        <x-textbox name="horas" label="Horas" type="number" value="{{$data->horas}}" disabled="true"/>
        <x-textbox name="atividade" label="Atividade" type="text" value="{{$data->atividade}}" disabled="true"/>
        <x-textbox name="categoria" label="Categoria" type="text" value="{{$data->categoria->nome}}" disabled="true"/>
        <x-textbox name="aluno" label="Aluno" type="text" value="{{$data->aluno->nome}}" disabled="true"/>
        <x-textbox name="user" label="User" type="text" value="{{$data->user->name}}" disabled="true"/>
        <div class="row">
            <div class="col text-start">
                <x-button label="Voltar" type="link" route="comprovante.index" color="secondary"/>
            </div>
        </div>
    </form>
    
@endsection