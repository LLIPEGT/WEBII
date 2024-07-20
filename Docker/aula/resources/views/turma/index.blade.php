@extends('templates/main', ['titulo'=>"TURMA"])

@section('conteudo')

    <x-datatable 
        title="Tabela de Turmas" 
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