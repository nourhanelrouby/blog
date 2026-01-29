<?php

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


if (!function_exists('multiLanguageSave')) {
    function multiLanguageSave($model, array $validated)
    {
        $languages = LaravelLocalization::getSupportedLocales(); // ['en' => [...], 'ar' => [...], 'fr' => [...]]

        //                       en        [name,native,...]
        foreach ($languages as $langCode => $props) {
            if (isset($validated[$langCode])) {
                //        request     en           name      first_name
                //        request     an           name      اول اسم
                foreach ($validated[$langCode] as $field => $value) {
                    $model->translateOrNew($langCode)->{$field} = $value;
                }
            }
        }
        $model->save();
    }
}



if (!function_exists('successResponse')) {
    function successResponse($data = null, $message = 'Operation successful', $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'code' => $code,
        ], $code);
    }
}


if (!function_exists('errorResponse')) {
    function errorResponse($data = null, $message = 'An error occurred', $code = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
            'code' => $code,
        ], $code);
    }
}



function paginatedResponse($resourceOrPaginator, $message = 'Data retrieved successfully', $code = 200)
{
    if ($resourceOrPaginator instanceof AnonymousResourceCollection) {
        $paginator = $resourceOrPaginator->resource;
        $data = $resourceOrPaginator->collection;
    } elseif ($resourceOrPaginator instanceof LengthAwarePaginator) {
        $paginator = $resourceOrPaginator;
        $data = $paginator->items();
    } else {
        throw new InvalidArgumentException('paginatedResponse expects paginator or resource collection');
    }

    return response()->json([
        'success' => true,
        'message' => $message,
        'data' => $data,
        'meta' => [
            'current_page' => $paginator->currentPage(),
            'per_page'     => $paginator->perPage(),
            'total'        => $paginator->total(),
            'last_page'    => $paginator->lastPage(),
            'from'         => $paginator->firstItem(),
            'to'           => $paginator->lastItem(),
        ],
        'links' => [
            'first' => $paginator->url(1),
            'last'  => $paginator->url($paginator->lastPage()),
            'prev'  => $paginator->previousPageUrl(),
            'next'  => $paginator->nextPageUrl(),
        ],
        'code' => $code,
    ], $code);
}



if (!function_exists('validationErrorResponse')) {
    function validationErrorResponse($errors, $message = 'Validation failed', $code = 422)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $$errors,
            'code' => $code,
        ], $code);
    }
}
