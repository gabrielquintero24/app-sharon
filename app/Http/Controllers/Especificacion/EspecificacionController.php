<?php

namespace App\Http\Controllers\Especificacion;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Especificacion\Especificacion;
use App\Repositories\Especificacion\EspecificacionRepository;
use App\Http\Requests\Especificacion\CreateEspecificacionRequest;
use App\Http\Requests\Especificacion\UpdateEspecificacionRequest;

class EspecificacionController extends Controller
{
    protected $repository;

    public function __construct(EspecificacionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return view('dashboard.especificacion.index');
    }

    public function store(CreateEspecificacionRequest $request)
    {
        try {
            $especificacion = $this->repository->create($request->input());
            return response()->json($especificacion, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateEspecificacionRequest $request, Especificacion $Especificacion)
    {
        try {
            $data = $this->repository->update($Especificacion, $request->input());
            return response()->json($data, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getEspecificaciones(Request $request)
    {
        try {
            $query = $this->setQuery();
            return renderDataTable(
                $query,
                $request,
                Especificacion::RELATION_SHIPS,
                [
                    'especificacion.*',
                ]
            );
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getEspecificacion($id)
    {
        try {
            $especificacion = $this->repository->getByID($id);
            return response()->json($especificacion, Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function setQuery()
    {
        return Especificacion::query();
    }

    public function listEspecificacionNombresAndIds(){
        return Especificacion::select('id', 'nombre')->get();
    }

}
