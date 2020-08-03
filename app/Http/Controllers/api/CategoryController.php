<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller {

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request) {
        $categories = Category::get();
        return response()->json([
            'status' => 'success',
            'result' => $categories,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request) {
        $category       = new Category();
        $category->name = $request->input('name');
        $category->content = $request->input('content');
        if ($category->save()) {
            return response()->json([
                'status' => 'success',
                'result' => $category,
            ]);
        }
        return response()->json([
            'status' => 'error',
        ]);
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return JsonResponse
     */
    public function show(Request $request, $id) {
        $category = Category::where('id', $id)->first();
        return response()->json([
            'status' => 'success',
            'result' => $category,
        ]);
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return JsonResponse
     */
    public function update(Request $request, $id) {
        $category       = Category::where('id', $id)->first();
        $category->name = $request->input('name');
        if ($category->save()) {
            return response()->json([
                'status' => 'success',
                'result' => $category,
            ]);
        }
        return response()->json([
            'status' => 'error',
        ]);
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return JsonResponse
     */
    public function delete(Request $request, $id) {
        $category = Category::where('id', $id)->first();
        if ($category->delete()) {
            return response()->json([
                'status' => 'success',
                'result' => 'Delete complete',
            ]);
        }
        return response()->json([
            'status' => 'error',
        ]);
    }
}
