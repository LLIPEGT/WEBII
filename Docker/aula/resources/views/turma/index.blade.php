@extends('templates/main', ['titulo'=>"Turmas"])

@section('conteudo')

    <x-datatable 
        title="Tabela de Turma" 
        :header="['ID', 'Ano', 'Ações']" 
        crud="turma" 
        :data="$data"
        :fields="['id', 'ano']" 
        :hide="[true, false, false]"
        remove="ano"
        create="turma.create" 
        id=""
        modal=""
        
    /> 
@endsection