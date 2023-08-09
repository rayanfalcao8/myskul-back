<?php

namespace Modules\Core\Http\Controllers\Api;

use Dingo\Api\Http\Request;
use Modules\Core\Entities\Country;

class CountryController extends CoreController
{
    public function getAllCountries(Request $request)
    {
        $countries = Country::paginate($request->query('per_page') ?? 10);

        return $this->successResponse(
            __('Get countries list paginate successfully !'),
            ['countries' => $countries]
        );
    }
}
