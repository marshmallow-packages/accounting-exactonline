<?php

namespace Marshmallow\ExactOnline\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExactOnlineController extends Controller
{
    public function show(Request $request)
    {
        $model_name = $request->model;
        $model = $model_name::find($request->resourceId);

        if ($model->exact) {
            return response()->json([
                'data' => $model->getDataFromExact(),
                'fields' => $model->getExactModelFields(),
            ]);
        }

        return response()->json([
            'error' => 'There is no Exact Online data available to show here',
        ]);
    }
}
