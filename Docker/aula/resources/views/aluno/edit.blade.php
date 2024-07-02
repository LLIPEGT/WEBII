@extends('templates/main', ['titulo'=>"ALTERAR ALUNO"])

@section('conteudo')

    <form action="{{ route('aluno.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')
        <x-textbox name="nome" label="Nome" type="text" :value="$data->nome" disabled="false"/>
        <x-textbox name="email" label="Email" type="text" :value="$data->email" disabled="false"/>
        <x-selectbox name="curso_id" label="Curso" color="success" :data="$curso" field="nome" disabled="false" :select="$data->curso_id"/>
        <x-selectbox name="turma_id" label="Turma" color="success" :data="$turma" field="ano" disabled="false" :select="$data->turma_id"/>
        <div class="row">
            <div class="col text-start">
                <x-button label="Voltar" type="link" route="aluno.index" color="secondary"/>
            </div>
            <div class="col text-end">
                <x-button label="Alterar" type="submit" route="" color="success"/>
            </div>
        </div>
    </form>
    
@endsection