@extends('templates/main', ['titulo'=>"DETALHES DA TURMA"])

@section('conteudo')

    <form action="{{ route('turma.store') }}" method="GET">
        @csrf
        <x-textbox name="ano" label="Ano" type="number" value="{{$data->ano}}" disabled="true"/>
        <x-textbox name="curso" label="Curso feito" type="text" value="{{$data->curso->nome}}" disabled="true"/>
        <div class="row">
            <div class="col text-start">
                <x-button label="Voltar" type="link" route="turma.index" color="secondary"/>
            </div>
        </div>
    </form>
    
@endsection