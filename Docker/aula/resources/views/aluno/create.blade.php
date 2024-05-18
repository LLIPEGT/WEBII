@extends('templates/main', ['titulo'=>"ALUNOS"])

@section('conteudo')

    <form action="{{ route('aluno.store') }}" method="POST">
        @csrf
        <x-textbox name="nome" label="Nome" type="text" value="null" disabled="false"/>
        <x-textbox name="cpf" label="CPF" type="number" value="null" disabled="false"/>
        <x-textbox name="email" label="Email" type="email" value="null" disabled="false"/>
        <x-textbox name="password" label="Password" type="password" value="null" disabled="false"/>
        <x-selectbox name="curso_id" label="Curso" color="success" :data="$curso" field="nome" disabled="false" select="-1"/>
        <x-selectbox name="turma_id" label="Turma" color="success" :data="$turma" field="nome" disabled="false" select="-1"/>
        <div class="row">
            <div class="col text-start">
                <x-button label="Voltar" type="link" route="aluno.index" color="secondary"/>
            </div>
            <div class="col text-end">
                <x-button label="Cadastrar" type="submit" route="" color="success"/>
            </div>
        </div>
    </form>

    @endsection