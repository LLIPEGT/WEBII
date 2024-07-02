@extends('templates/main', ['titulo'=>"NOVO COMPROVANTE"])

@section('conteudo')

    <form action="{{ route('comprovante.store') }}" method="POST">
        @csrf
        <x-textbox name="horas" label="Horas" type="number" value="null" disabled="false"/>
        <x-textbox name="atividade" label="Atividade" type="text" value="null" disabled="false"/>
        <x-selectbox name="user_id" label="Usuario" color="success" :data="$user" field="nome" disabled="false" select="-1"/>
        <x-selectbox name="categoria_id" label="Categoria" color="success" :data="$categoria" field="nome" disabled="false" select="-1"/>
        <x-selectbox name="aluno_id" label="Aluno" color="success" :data="$aluno" field="nome" disabled="false" select="-1"/>
        <div class="row">
            <div class="col text-start">
                <x-button label="Voltar" type="link" route="comprovante.index" color="secondary"/>
            </div>
            <div class="col text-end">
                <x-button label="Cadastar" type="submit" route="" color="success"/>
            </div>
        </div>
    </form>
    
@endsection