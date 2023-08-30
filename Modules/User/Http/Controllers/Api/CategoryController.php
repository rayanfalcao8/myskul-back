<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\User\Entities\Category;
use Modules\User\Transformers\CategoryResource;

class CategoryController extends CoreController
{
    public function index()
    {
        return $this->successResponse('Got categories successfully', [
            'categories' => CategoryResource::collection(Category::paginate())
        ]);
    }
    public function show($id)
    {
        return $this->successResponse('Got category by id successfully', [
            'category' => new CategoryResource(Category::find($id))
        ]);
    }
}
