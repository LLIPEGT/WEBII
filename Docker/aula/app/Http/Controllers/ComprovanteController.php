<?php

namespace App\Http\Controllers;

use App\Models\Comprovante;
use App\Repositories\AlunoRepository;
use App\Repositories\CategoriaRepository;
use App\Repositories\ComprovanteRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class ComprovanteController extends Controller
{
    protected $repository;

    public function __construct() {
        $this->repository = new ComprovanteRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->repository->selectAllWith(['user', 'categoria', 'aluno']);
        //return $data;
        return view('comprovante.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = (new UserRepository())->selectAll((object) [ "use" => false, "rows" => 0]);
        $categoria = (new CategoriaRepository())->selectAll((object) [ "use" => false, "rows" => 0]);
        $aluno = (new AlunoRepository())->selectAll((object) [ "use" => false, "rows" => 0]);
        return view('comprovante.create', compact(['user', 'categoria', 'aluno']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $objUser = (new UserRepository())->findById($request->user_id);
        $objCategoria = (new CategoriaRepository())->findById($request->categoria_id);
        $objAluno = (new AlunoRepository())->findById($request->aluno_id);

        if(isset($objCategoria) && isset($objUser) && isset($objAluno)){
            $obj = new Comprovante();
            $obj->horas = $request->horas;
            $obj->atividade = $request->atividade;
            $obj->categoria()->associate($objCategoria);
            $obj->aluno()->associate($objAluno);
            $obj->user()->associate($objUser);
            $this->repository->save($obj);

            return redirect()->route('comprovante.index');
        }
        return view('message')
            ->with('template', "main")
            ->with('type', "danger")
            ->with('titulo', "OPERAÇÃO INVÁLIDA")
            ->with('message', "Não foi possível efetuar o registro!")
            ->with('link', "comprovante.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->repository->findById($id);

        if($data){
            return view('comprovante.show', compact('data'));
        }
        return view('message')
            ->with('template', "main")
            ->with('type', "danger")
            ->with('titulo', "OPERAÇÃO INVÁLIDA")
            ->with('message', "Não foi possível visualizar o registro!")
            ->with('link', "comprovante.index");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = $this->repository->findById($id);
        if(isset($data)){
            $categoria = (new CategoriaRepository())->selectAll();
            $aluno = (new AlunoRepository())->selectAll();
            $user = (new UserRepository())->selectAll();
            return view('comprovante.edit', compact(['data', 'categoria', 'aluno', 'user']));
        }
        return view('message')
        ->with('template', "main")
        ->with('type', "warning")
        ->with('titulo', "OPERAÇÃO INVÁLIDA")
        ->with('message', "Comprovante não encontrado para alteração!")
        ->with('link', "comprovante.index");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $obj = $this->repository->findById($id);
        $objUser = (new UserRepository())->findById($request->user_id);
        $objCategoria = (new CategoriaRepository())->findById($request->categoria_id);
        $objAluno = (new AlunoRepository())->findById($request->aluno_id);

        if(isset($obj ,$objAluno, $objCategoria, $objUser)){
            $obj->horas = $request->horas;
            $obj->atividade = $request->atividade;
            $obj->categoria()->associate($objCategoria);
            $obj->aluno()->associate($objAluno);
            $obj->user()->associate($objUser);
            $this->repository->save($obj);

            return redirect()->route('comprovante.index');
        }
        return view('message')
            ->with('template', "main")
            ->with('type', "danger")
            ->with('titulo', "OPERAÇÃO INVÁLIDA")
            ->with('message', "Não foi possível efetuar o registro!")
            ->with('link', "comprovante.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($this->repository->delete($id)){
            return redirect()->route('comprovante.index');
        }
        return view('message')
            ->with('template', "main")
            ->with('type', "danger")
            ->with('titulo', "OPERAÇÃO INVÁLIDA")
            ->with('message', "Não foi possível efetuar o registro!")
            ->with('link', "comprovante.index");
    }
}
