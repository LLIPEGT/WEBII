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
        //
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
            return "<h1>Store - OK!</h1>";
        }
        return "<h1>Store - ERRO!</h1>";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $obj = $this->repository->findById($id);
        if(isset($obj)){
            return $obj;
        }

        return "<h1>Show - ERRO!</h1>";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
            return "<h1>Store - OK!</h1>";
        }
        return "<h1>Store - ERRO!</h1>";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($this->repository->delete($id)){
            return "<h1>delete - OK!</h1>";
        }

        return "<h1>delete - error!</h1>";
    }
}