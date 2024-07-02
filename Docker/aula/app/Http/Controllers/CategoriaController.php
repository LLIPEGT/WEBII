<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Repositories\CategoriaRepository;
use App\Repositories\CursoRepository;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{

    private $repository;

    public function __construct() {
        $this->repository = new CategoriaRepository();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->repository->selectAllWith(['curso']);
        return view('categoria.index', compact('data'));
        //return $data;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $curso = (new CursoRepository())->selectAll((object) ["use" => false, "rows" => 0]);

        return view('categoria.create', compact(['curso']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $objCurso = (new CursoRepository())->findById($request->curso_id);
        
        if(isset($objCurso)) {
            $obj = new Categoria();
            $obj->nome = $request->nome;
            $obj->maximo_horas = $request->maximo_horas;            
            $obj->curso()->associate($objCurso);
            $this->repository->save($obj);
            return redirect()->route('categoria.index');
        }
        return view('message')
        ->with('template', "main")
        ->with('type', "danger")
        ->with('titulo', "OPERAÇÃO INVÁLIDA")
        ->with('message', "Não foi possível efetuar o registro!")
        ->with('link', "categoria.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        /*$obj = $this->repository->findById($id);

        if(isset($obj)){
            $data = $this->repository->findById($id);
            return $data;
        }*/

        $data = $this->repository->findByIdWith(['curso'], $id);
        return view('categoria.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = $this->repository->findById($id);
        if(isset($data)){
            $cursos = (new CursoRepository())->selectAll();
            return view('categoria.edit', compact(['data', 'cursos']));
        }
        return view('message')
        ->with('template', "main")
        ->with('type', "warning")
        ->with('titulo', "OPERAÇÃO INVÁLIDA")
        ->with('message', "Categoria não encontrada para alteração!")
        ->with('link', "categoria.index");
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $obj = $this->repository->findById($id);
        $objCurso = (new CursoRepository())->findById($request->curso_id);

        if(isset($obj) && isset($objCurso)){
            $obj->nome = $request->nome;
            $obj->maximo_horas = $request->maximo_horas;
            $obj->curso()->associate($objCurso);
            $this->repository->save($obj);
            return "<h1>Update - OK!</h1>";
        }
        return "<h1>Update - ERRO!</h1>";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($this->repository->delete($id)) {
            return "<h1>Delete - OK!</h1>";
        }
        
        return "<h1>Delete - Not found !</h1>";
    }
}
