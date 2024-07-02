@extends('templates/main', ['titulo'=>"PROFESSOR"])

@section('conteudo')

    <x-datatable 
        title="Tabela de Professores" 
        :header="['ID', 'Nome', 'Ações']" 
        crud="professor" 
        :data="$data"
        :fields="['id', 'nome']" 
        :hide="[true, false, false]"
        remove="nome"
        create="professor.create" 
        id=""
        modal=""
        
    /> 
@endsection