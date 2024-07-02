<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\CursoRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    protected $repository;

    public function __construct() {
        $this->repository = new UserRepository();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->repository->selectAllWith(['role', 'curso']);
        return view('users.index', compact('data'));
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
        $objRole = (new RoleRepository())->findById($request->role_id);
        
        if(isset($objCurso) && isset($objRole)) {
            $obj = new User();
            $obj->name = mb_strtoupper($request->nome, 'UTF-8');
            $obj->email = mb_strtolower($request->email, 'UTF-8');
            $obj->password = Hash::make($request->password); 
            $obj->curso()->associate($objCurso);
            $obj->role()->associate($objRole);
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
        $data = $this->repository->findById($id);

        if(isset($data)){
            return view('users.show', compact('data'));
        }

        return '<h1> show - error </h1>';
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
        $objRole = (new RoleRepository())->findById($request->role_id);
        
        if(isset($obj) && isset($objCurso) && isset($objRole)) {
            $obj->name = mb_strtoupper($request->nome, 'UTF-8');
            $obj->email = mb_strtolower($request->email, 'UTF-8');
            $obj->password = Hash::make($request->password); 
            $obj->curso()->associate($objCurso);
            $obj->role()->associate($objRole);
            $this->repository->save($obj);
            return "<h1>update - OK!</h1>";
        }
        return "<h1>update - ERRO!</h1>";
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($this->repository->delete($id)){
            return '<h1>delete - ok </h1>';
        }
        return '<h1>delete - error </h1>';
    }
}
