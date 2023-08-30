<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\User\Entities\School;
use Modules\User\Transformers\SchoolResource;

class SchoolController extends CoreController
{
    public function index()
    {
        return $this->successResponse('Got schools successfully', [
            'schools' => SchoolResource::collection(School::paginate())
        ]);
    }
    public function show($id)
    {
        return $this->successResponse('Got school by id successfully', [
            'school' => new SchoolResource(School::find($id))
        ]);
    }
}
