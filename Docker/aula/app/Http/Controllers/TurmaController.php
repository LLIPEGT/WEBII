<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use App\Repositories\CursoRepository;
use App\Repositories\TurmaRepository;
use Illuminate\Http\Request;

class TurmaController extends Controller
{

    protected $repository;

    public function __construct() {
        $this->repository = new TurmaRepository();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->repository->selectAllWith(['curso']);
        //return $data;
        return view('turma.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cursos = (new CursoRepository())->selectAll((object) ["use" => false, "rows" => 0]);
        return view('turma.create', compact(['cursos']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $objCurso = (new CursoRepository())->findById($request->curso_id);
        
        if(isset($objCurso)) {
            $obj = new Turma();
            $obj->ano = $request->ano;
            $obj->curso()->associate($objCurso);
            $this->repository->save($obj);
            return redirect()->route('turma.index');
        }
        return "<h1>Store - ERRO!</h1>";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {   
        $data = $this->repository->findByIdWith(['curso'], $id);
        if(isset($data)){
            return view('turma.show', compact('data'));;
        }   
            return "ERROO";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = $this->repository->findById($id);
        if(isset($data)){
            $cursos = (new CursoRepository())->selectAll();

            return view('turma.edit', compact(['data', 'cursos']));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $obj = $this->repository->findById($id);
        $objCurso = (new CursoRepository())->findById($request->curso_id);

        if(isset($obj) && isset($objCurso)){
            $obj->ano = $request->ano;
            $obj->curso()->associate($objCurso);
            $this->repository->save($obj);
            ;
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
