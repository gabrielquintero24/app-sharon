<?php

namespace App\Http\Controllers\Cortes;

use App\Models\Corte\Corte;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Cortes\CorteRepository;
use App\Http\Requests\Cortes\CreateCorteRequest;
use App\Http\Requests\Cortes\UpdateCorteRequest;
use App\Models\Corte\CorteEspecificacion;

class CorteEspecificacionController extends Controller
{
    protected $repository;

    public function __construct(CorteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return view('dashboard.cortes.corte_especificacion');
    }

    public function getVinculaciones(Request $request)
    {
        Log::debug($request->all());
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

    private function setQuery()
    {
        return CorteEspecificacion::query()
            ->leftJoin('especificacion', 'especificacion.id', '=', 'corte_especificacion.especificacion_id');
    }
}
