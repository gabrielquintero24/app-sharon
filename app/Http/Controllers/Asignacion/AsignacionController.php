<?php

namespace App\Http\Controllers\Asignacion;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Asignacion\Asignacion;
use App\Repositories\Asignacion\AsignacionRepository;
use App\Http\Requests\Asignacion\CreateAsignacionRequest;
use App\Http\Requests\Asignacion\UpdateAsignacionRequest;

class AsignacionController extends Controller
{
    protected $repository;

    public function __construct(AsignacionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return view('dashboard.asignacion.index');
    }

    public function store(CreateAsignacionRequest $request)
    {
        try {
            $data = $this->repository->create($request->input());
            return response()->json($data, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateAsignacionRequest $request, Asignacion $Asignacion)
    {
        try {
            $data = $this->repository->update($Asignacion, $request->input());
            return response()->json($data, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAsignaciones(Request $request)
    {
        try {
            $query = $this->setQuery();
            return renderDataTable(
                $query,
                $request,
                Asignacion::RELATION_SHIPS,
                [
                    'asignacion.id',
                    'corte.nombre',
                    'corte.codigo_referencia',
                    'asignacion.corte_id',
                    'asignacion.modista_id',
                ]
            );
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAsignacion($id)
    {
        try {
            $asignacion = $this->repository->getByID($id);
            return response()->json($asignacion, Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function setQuery()
    {
        return Asignacion::query()
            ->leftJoin('corte', 'corte.id', '=', 'asignacion.corte_id');
    }
}
