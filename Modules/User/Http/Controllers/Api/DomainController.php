<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\User\Entities\Domain;
use Modules\User\Transformers\DomainResource;

class DomainController extends CoreController
{
    public function index()
    {
        return $this->successResponse('Got domains successfully', [
            'domains' => DomainResource::collection(Domain::paginate())
        ]);
    }
    public function show($id)
    {
        return $this->successResponse('Got domain by id successfully', [
            'domain' => new DomainResource(Domain::find($id))
        ]);
    }
}
