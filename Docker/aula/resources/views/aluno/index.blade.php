@extends('templates/main', ['titulo'=>"ALUNO"])

@section('conteudo')

    <x-datatable
        title="Tabela de Alunos"
        :header="['ID', 'Nome', 'Ações']"
        crud="aluno"
        :data="$data"
        :fields="['id', 'nome']"
        :hide="[true, false, false]"
        remove="nome"
        create="aluno.create"
        id=""
        modal=""
    />

    @endsection