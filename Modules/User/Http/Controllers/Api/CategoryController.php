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
        if($request->level_id && $request->speciality_id) {
            if (in_array($request->level_id, [1,2,3,4,5])) {
                return $this->successResponse('Got categories successfully', [
                    'categories' => CategoryResource::collection(Category::query()->filter($request)->get()[0])
                ]);
            } else {
                if ($request->speciality_id == 10) {
                    return $this->successResponse('Got categories successfully', [
                        'categories' => CategoryResource::collection(array_shift(Category::query()->filter($request)->get()))
                    ]);
                }
                return $this->successResponse('Got categories successfully', [
                    'categories' => CategoryResource::collection(Category::query()->filter($request)->get()[0])
                ]);

            }
        }
    }
    public function show($id)
    {
        return $this->successResponse('Got category by id successfully', [
            'category' => new CategoryResource(Category::find($id))
        ]);
    }
}
