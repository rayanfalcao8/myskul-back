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
        $level_id = $request->user()->level_id;
        $speciality_id = $request->user()->speciality_id;
        if($level_id && $speciality_id) {
            if ($level_id >= 1 && $level_id <= 5) {
                return $this->successResponse('Got categories successfully', [
                    'categories' => CategoryResource::collection(Category::query()->filter($request)->limit(1)->get())
                ]);
            } else {
                if ($speciality_id == 10) {
                    return $this->successResponse('Got categories successfully', [
                        'categories' => CategoryResource::collection(Category::query()->filter($request)->get()->forget(0))
                    ]);
                }
                return $this->successResponse('Got categories successfully', [
                    'categories' => CategoryResource::collection(Category::query()->filter($request)->limit(1)->get())
                ]);

            }
        }
        return $this->successResponse('Got categories successfully', [
            'categories' => CategoryResource::collection(Category::query()->filter($request)->get())
        ]);
    }
    public function show($id)
    {
        return $this->successResponse('Got category by id successfully', [
            'category' => new CategoryResource(Category::find($id))
        ]);
    }
}
