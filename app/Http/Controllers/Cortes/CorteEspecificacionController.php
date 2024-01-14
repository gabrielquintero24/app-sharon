<?php

namespace App\Http\Controllers\Cortes;

use App\Models\Corte\Corte;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Corte\CorteEspecificacion;
use App\Repositories\CorteEspecificacion\CorteEspecificacionRepository;
use App\Http\Requests\CorteEspecificacion\CreateCorteEspecificacionRequest;

class CorteEspecificacionController extends Controller
{
    protected $repository;

    public function __construct(CorteEspecificacionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return view('dashboard.cortes.corte_especificacion');
    }

    public function store(CreateCorteEspecificacionRequest $request)
    {
        try {
            $data = $this->repository->create($request->input());
            return response()->json($data, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(CreateCorteEspecificacionRequest $request, CorteEspecificacion $CorteEspecificacion)
    {
        try {
            $data = $this->repository->update($CorteEspecificacion, $request->input());
            return response()->json($data, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getVinculaciones(Request $request)
    {
        try {
            $query = $this->setQuery();
            return renderDataTable(
                $query,
                $request,
                CorteEspecificacion::RELATION_SHIPS,
                [
                    'corte_especificacion.id',
                    'corte_especificacion.cantidad',
                    'corte_especificacion.precio',
                    'especificacion.nombre as esp_nombre'
                ]
            );
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getVinculacion($id)
    {
        try {
            $data = $this->repository->getByID($id);
            return response()->json($data, Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function setQuery()
    {
        return CorteEspecificacion::query()
            ->leftJoin('especificacion', 'especificacion.id', '=', 'corte_especificacion.especificacion_id');
    }
}
