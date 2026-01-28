<?php

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Pagination\LengthAwarePaginator;

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

if (!function_exists('paginatedResponse')) {
    function paginatedResponse(LengthAwarePaginator $pagintor, $message = 'Data retrieved successfully', $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $pagintor->items(),
            'meta' => [
                'current_page' => $pagintor->currentPage(),
                'per_page' => $pagintor->perPage(),
                'total' => $pagintor->total(),
                'last_page' => $pagintor->lastPage(),
                'from' => $pagintor->firstItem(),
                'to' => $pagintor->lastItem()
            ],
            'links' => [
                'first' => $pagintor->url(1),
                'last' => $pagintor->url($pagintor->lastPage()),
                'prev' => $pagintor->previousPageUrl(),
                'next' => $pagintor->nextPageUrl(),
            ],

            'code' => $code,
        ], $code);
    }
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
