<?php

namespace App\Http\Controllers\Cortes;

use App\Models\Corte\Corte;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Cortes\CorteRepository;
use App\Http\Requests\Cortes\CreateCorteRequest;
use App\Http\Requests\Cortes\UpdateCorteRequest;

class CorteController extends Controller
{
    protected $repository;

    public function __construct(CorteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return view('dashboard.cortes.index');
    }

    public function store(CreateCorteRequest $request)
    {
        try {
            $corte = $this->repository->create($request->input());
            return response()->json($corte, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateCorteRequest $request, Corte $Corte)
    {
        try {
            $data = $this->repository->update($Corte, $request->input());
            return response()->json($data, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getCortes()
    {
        try {
            $cortes = $this->repository->getAll();
            return response()->json($cortes, Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getCorte($id)
    {
        try {
            $cortes = $this->repository->getByID($id);
            return response()->json($cortes, Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
