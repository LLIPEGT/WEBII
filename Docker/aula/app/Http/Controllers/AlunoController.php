<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\User;
use App\Repositories\AlunoRepository;
use App\Repositories\CursoRepository;
use App\Repositories\TurmaRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AlunoController extends Controller
{
    protected $repository;

    public function __construct() {
        $this->repository = new AlunoRepository();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->repository->selectAllWith(['user', 'curso', 'turma']);
        return view('aluno.index', compact('data'));
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $curso = (new CursoRepository())->selectAll((object)["use" => false, "row" => 0]);
        $turma = (new TurmaRepository())->selectAll((object)["use"=>false, "row"=>0]);

        return view('aluno.create', compact(['curso', 'turma']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $objCurso = (new CursoRepository())->findById($request->curso_id);
        $objUser = (new UserRepository())->findById($request->user_id);
        $objTurma = (new TurmaRepository())->findById($request->turma_id);
        
        
        if(isset($objCurso) && isset($objTurma)) {
            $obj = new Aluno();
            $obj->nome = mb_strtoupper($request->nome, 'UTF-8');
            $obj->cpf = $request->cpf;
            $obj->email = mb_strtolower($request->email, 'UTF-8');
            $obj->password = Hash::make($request->password);
            $obj->curso()->associate($objCurso);
            $obj->turma()->associate($objTurma);
            $this->repository->save($obj);
            return redirect()->route('aluno.index');
        }
        return view('message')
            ->with('template', "main")
            ->with('type', "danger")
            ->with('titulo', "OPERAÇÃO INVÁLIDA")
            ->with('message', "Não foi possível efetuar o registro!")
            ->with('link', "aluno.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->repository->findById($id);
        if(isset($data)){
            return view('aluno.show', compact(['data']));
        }

        return view('message')
            ->with('template', "main")
            ->with('type', "danger")
            ->with('titulo', "OPERAÇÃO INVÁLIDA")
            ->with('message', "Não foi possível buscar o registro!")
            ->with('link', "aluno.index");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = $this->repository->findById($id);
        if(isset($data)){
            $curso = (new CursoRepository())->selectAll();
            $turma = (new TurmaRepository())->selectAll();
            return view('aluno.edit', compact(['data', 'curso', 'turma']));
        }


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $obj = $this->repository->findById($id);
        $objCurso = (new CursoRepository())->findById($request->curso_id);
        $objUser = (new UserRepository())->findById($request->user_id);
        $objTurma = (new TurmaRepository())->findById($request->turma_id);
        if(isset($objCurso) && isset($objTurma) && isset($obj)) {
            $obj->nome = mb_strtoupper($request->nome, 'UTF-8');
            $obj->cpf = $request->cpf;
            $obj->email = mb_strtolower($request->email, 'UTF-8');
            $obj->password = Hash::make($request->password);
            $obj->curso()->associate($objCurso);
            $obj->turma()->associate($objTurma);
            $this->repository->save($obj);
            return redirect()->route('aluno.index');
        }
        return view('message')
            ->with('template', "main")
            ->with('type', "danger")
            ->with('titulo', "OPERAÇÃO INVÁLIDA")
            ->with('message', "Não foi possível atualizar o registro!")
            ->with('link', "aluno.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($this->repository->delete($id)){
            return redirect()->route('aluno.index');
        }

        return view('message')
            ->with('template', "main")
            ->with('type', "danger")
            ->with('titulo', "OPERAÇÃO INVÁLIDA")
            ->with('message', "Não foi possível efetuar o registro!")
            ->with('link', "aluno.index");
    }
}