<?php

namespace App\Http\Controllers;

use App\Repositories\CursoRepository;
use App\Repositories\EixoRepository;
use App\Repositories\NivelRepository;
use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{

    protected $repository;

    public function __construct(){
        $this->repository = new CursoRepository();
    }

    public function index() {
        
        $data = $this->repository->selectAllWith(['eixo', 'nivel']);
        return view('curso.index', compact('data'));
        //return $data;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $eixos = (new EixoRepository())->selectAll((object) ["use" => false, "rows" => 0]);
        $niveis = (new NivelRepository())->selectAll((object) ["use" => false, "rows" => 0]);
        return view('curso.create', compact(['eixos', 'niveis']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $objEixo = (new EixoRepository())->findById($request->eixo_id);
        $objNivel = (new NivelRepository())->findById($request->nivel_id);

        if(isset($objEixo) && isset($objNivel)) {
            $obj = new Curso();
            $obj->nome = mb_strtoupper($request->nome, 'UTF-8');
            $obj->sigla = mb_strtoupper($request->sigla, 'UTF-8');
            $obj->total_horas = $request->horas;
            $obj->eixo()->associate($objEixo);
            $obj->nivel()->associate($objNivel);
            $this->repository->save($obj);
            return redirect()->route('curso.index');
        }

        return view('message')
            ->with('template', "main")
            ->with('type', "danger")
            ->with('titulo', "OPERAÇÃO INVÁLIDA")
            ->with('message', "Não foi possível efetuar o registro!")
            ->with('link', "curso.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->repository->findByIdWith(['eixo', 'nivel'], $id);
        return view('curso.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = $this->repository->findById($id);
        if(isset($data)) {
            $eixos = (new EixoRepository())->selectAll();
            $niveis = (new NivelRepository())->selectAll();
            return view('curso.edit', compact(['data', 'eixos', 'niveis']));
        }
        return view('message')
        ->with('template', "main")
        ->with('type', "warning")
        ->with('titulo', "OPERAÇÃO INVÁLIDA")
        ->with('message', "Curso não encontrado para alteração!")
        ->with('link', "curso.index");
        
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $obj = $this->repository->findById($id);
        $objEixo = (new EixoRepository())->findById($request->eixo_id);
        $objNivel = (new NivelRepository())->findById($request->nivel_id);
        if(isset($obj) && isset($objEixo) && isset($objNivel)) {
            $obj->nome = mb_strtoupper($request->nome, 'UTF-8');
            $obj->sigla = mb_strtoupper($request->sigla, 'UTF-8');
            $obj->total_horas = $request->horas;
            $obj->eixo()->associate($objEixo);
            $obj->nivel()->associate($objNivel);
            $this->repository->save($obj);
            return redirect()->route('curso.index');
        }
        return view('message')
            ->with('template', "main")
            ->with('type', "danger")
            ->with('titulo', "OPERAÇÃO INVÁLIDA")
            ->with('message', "Não foi possível efetuar o registro!")
            ->with('link', "curso.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($this->repository->delete($id)) {
            return redirect()->route('curso.index');
        }
            return view('message')
            ->with('template', "main")
            ->with('type', "danger")
            ->with('titulo', "OPERAÇÃO INVÁLIDA")
            ->with('message', "Não foi possível efetuar o registro!")
            ->with('link', "curso.index");
    }
}
