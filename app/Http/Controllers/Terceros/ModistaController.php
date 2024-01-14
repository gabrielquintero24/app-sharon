<?php

namespace App\Http\Controllers\Terceros;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Terceros\Modista;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Terceros\ModistaRepository;
use App\Http\Requests\Terceros\CreateModistaRequest;
use App\Http\Requests\Terceros\UpdateModistaRequest;
use Illuminate\Validation\Rules\Enum;

class ModistaController extends Controller
{
    protected $repository;

    public function __construct(ModistaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return view('dashboard.terceros.modista');
    }

    public function store(CreateModistaRequest $request)
    {
        try {
            $modista = $this->repository->create($request->input());
            return response()->json($modista, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateModistaRequest $request, Modista $Modista)
    {
        try {
            $data = $this->repository->update($Modista, $request->input());
            return response()->json($data, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getModistas(Request $request)
    {
        try {
            $query = $this->setQuery();
            return renderDataTable(
                $query,
                $request,
                Modista::RELATION_SHIPS,
                [
                    'modista.*',
                    'enum_tipo_modista.name'
                ]
            );
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getModista($id)
    {
        try {
            $modistas = $this->repository->getByID($id);
            return response()->json($modistas, Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function setQuery()
    {
        return Modista::query()
            ->leftJoin('enums as enum_tipo_modista', 'enum_tipo_modista.id', '=', 'modista.tipo_modista_id');
    }

    public function listModistaNombresAndIds(){
        return Modista::select('id', 'nombre')->get();
    }
}
