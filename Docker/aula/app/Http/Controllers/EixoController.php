<?php

namespace App\Http\Controllers;

use App\Models\Eixo;
use Illuminate\Http\Request;
use App\Repositories\EixoRepository;

class EixoController extends Controller
{

    protected $repository;

    public function __construct(){
            $this->repository = new EixoRepository();
    }

    public function index() {
        $data = $this->repository->selectAllWith(['curso']);
        return view('eixo.index', compact('data'));
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('eixo.create');
    }

    public function store(Request $request)
    {
        $obj = new Eixo();
        $obj->nome = mb_strtoupper($request->nome, 'UTF-8');
        $this->repository->save($obj);
        return redirect()->route('eixo.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->repository->findById($id);
        return view('eixo.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = $this->repository->findById($id);
        if(isset($data)){
            return view('eixo.edit', compact('data'));
        }

        return view('message')
        ->with('template', "main")
        ->with('tyoe', "warning")
        ->with('titulo', "OPERAÇÃO INVÁLIDA")
        ->with('message', "Eixo não encontrado para alteração")
        ->with('link', "eixo.index");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $obj = $this->repository->findById($id);

        if(isset($obj)) {
            $obj->nome = mb_strtoupper($request->nome, 'UTF-8');
            $this->repository->save($obj);
            return redirect()->route('eixo.index');
        }
        return view('message')
            ->with('template', "main")
            ->with('type', "danger")
            ->with('titulo', "OPERAÇÃO INVÁLIDA")
            ->with('message', "Não foi possível efetuar o registro!")
            ->with('link', "eixo.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($this->repository->delete($id)) {
            return redirect()->route('eixo.index');
        }
        return view('message')
            ->with('template', "main")
            ->with('type', "danger")
            ->with('titulo', "OPERAÇÃO INVÁLIDA")
            ->with('message', "Não foi possível efetuar o registro!")
            ->with('link', "eixo.index");
    }
}
