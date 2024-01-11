<?php

namespace App\Http\Controllers\Configuration;

use Illuminate\Http\Response;
use App\Models\Configuration\Enums;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ConfigurationController extends Controller
{
    public function listEnums($name)
    {
        try {
            return Enums::getChildrens($name);
        } catch (\Exception $ex) {
            Log::debug($ex->getMessage());
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
