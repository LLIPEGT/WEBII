@extends('templates/main', ['titulo'=>"CATEGORIA"])

@section('conteudo')

    <x-datatable
        title="Tabela de Categorias"
        :header="['ID', 'Nome', 'Ações']"
        crud="categoria"
        :data="$data"
        :fields="['id', 'nome']"
        :hide="[true, false, false]"
        remove="nome"
        create="categoria.create"
        id=""
        modal=""


    />
@endsection