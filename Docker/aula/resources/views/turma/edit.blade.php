@extends('templates/main', ['titulo'=>"ALTERAR TURMA"])

@section('conteudo')

    <form action="{{ route('turma.update', $data->id) }}" method="PUT">
        @csrf
        @method('PUT')
        <x-textbox name="ano" label="Ano" type="number" :value="$data->ano" disabled="false"/>
        <x-selectbox name="curso_id" label="Curso" color="success" :data="$cursos" field="nome" disabled="false" :select="$data->curso_id"/>
        <div class="row">
            <div class="col text-start">
                <x-button label="Voltar" type="link" route="turma.index" color="secondary"/>
            </div>
            <div class="col text-end">
                <x-button label="Alterar" type="submit" route="" color="success"/>
            </div>
        </div>
    </form>
    
@endsection