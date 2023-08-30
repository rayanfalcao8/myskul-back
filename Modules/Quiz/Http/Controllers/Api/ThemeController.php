<?php

namespace Modules\Quiz\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\Quiz\Entities\Theme;
use Modules\Quiz\Transformers\ThemeResource;

class ThemeController extends CoreController
{
    public function index()
    {
        return $this->successResponse('Got all themes successfully', [
            'themes' => ThemeResource::collection(Theme::all())
        ]);
    }

    public function show($id)
    {
        return $this->successResponse('Got theme by id successfully', [
            'theme' => new ThemeResource(Theme::find($id))
        ]);
    }

    public function getByLevel(Request $request)
    {
        return $this->successResponse('Got theme by id successfully', [
            'theme' => ThemeResource::collection(Theme::where('level_id', $request->level_id)->get())
        ]);
    }

    public function getByLevelAndSpeciality(Request $request)
    {
        return $this->successResponse('Got theme by id successfully', [
            'theme' => ThemeResource::collection(Theme::where('level_id', $request->level_id)->where('speciality_id', $request->speciality_id)->get())
        ]);

    }
}
