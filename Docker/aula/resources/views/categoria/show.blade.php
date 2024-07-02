@extends('templates/main', ['titulo'=>"DETALHES DA CATEGORIA"])

@section('conteudo')

    <form action="{{ route('categoria.store') }}" method="GET">
        @csrf
        <x-textbox name="nome" label="Nome" type="text" value="{{$data->nome}}" disabled="true"/>
        <x-textbox name="maximo_horas" label="Maximo de Horas" type="float" value="{{$data->maximo_horas}}" disabled="true"/>
        <x-textbox name="curso" label="Curso" type="text" value="{{$data->curso->nome}}" disabled="true"/>
        <div class="row">
            <div class="col text-start">
                <x-button label="Voltar" type="link" route="categoria.index" color="secondary"/>
            </div>
        </div>
    </form>

    @endsection