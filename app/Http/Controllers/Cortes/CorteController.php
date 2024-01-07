<?php

namespace App\Http\Controllers\Cortes;

use App\Http\Controllers\Controller;
use App\Repositories\Terceros\ModistaRepository;

class CorteController extends Controller
{
    protected $repository;

    public function __construct(ModistaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return view('dashboard.cortes.index');
    }
}
