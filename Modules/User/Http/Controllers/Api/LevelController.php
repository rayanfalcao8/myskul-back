<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\User\Entities\Level;
use Modules\User\Transformers\LevelResource;

class LevelController extends CoreController
{
    public function index()
    {
        return $this->successResponse('Got levels successfully', [
            'levels' => LevelResource::collection(Level::paginate())
        ]);
    }
    public function show($id)
    {
        return $this->successResponse('Got level by id successfully', [
            'level' => new LevelResource(Level::find($id))
        ]);
    }
}
