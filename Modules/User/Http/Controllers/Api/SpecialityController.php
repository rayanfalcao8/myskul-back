<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\User\Entities\Speciality;
use Modules\User\Transformers\SpecialityResource;

class SpecialityController extends CoreController
{
    public function index()
    {
        return $this->successResponse('Got specialities successfully', [
            'specialities' => SpecialityResource::collection(Speciality::paginate())
        ]);
    }
    public function show($id)
    {
        return $this->successResponse('Got speciality by id successfully', [
            'speciality' => new SpecialityResource(Speciality::find($id))
        ]);
    }
}
