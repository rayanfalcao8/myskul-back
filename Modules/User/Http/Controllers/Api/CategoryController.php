<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\User\Entities\Category;
use Modules\User\Transformers\CategoryResource;

class CategoryController extends CoreController
{
    public function index(Request $request)
    {
        return $this->successResponse('Got categories successfully', [
            'categories' => CategoryResource::collection(Category::query()->filter($request)->paginate($request->query("per_page", 10)))
        ]);
    }
    public function show($id)
    {
        return $this->successResponse('Got category by id successfully', [
            'category' => new CategoryResource(Category::find($id))
        ]);
    }
}
