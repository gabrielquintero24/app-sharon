<?php

namespace App\Http\Controllers\Terceros;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\Terceros\ModistaRepository;
use App\Http\Requests\Terceros\CreateModistaRequest;

class ModistaController extends Controller
{
    protected $repository;

    public function __construct(ModistaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(){
        return view('dashboard.terceros.modista');
    }

    public function store(CreateModistaRequest $request)
    {
        $modista = $this->repository->create($request->validated());

        return response()->json($modista, Response::HTTP_CREATED);
    }
}
