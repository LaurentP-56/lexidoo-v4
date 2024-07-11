<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Theme;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    /**
     * Get category by theme id
     *
     * @param Request $request
     * @return response
     * @author Bhavesh Vyas
     */
    public function getCategory(Request $request)
    {
        return response([
            'success'    => true,
            'categories' => getCategory($request->theme_id),
        ], 200);
    }

    /**
     * Get category by theme id
     *
     * @param Request $request
     * @return response
     * @author Bhavesh Vyas
     */
    public function getSubCategory(Request $request)
    {
        return response([
            'success'       => true,
            'subcategories' => getSubCategory($request->category_id),
        ], 200);
    }
}
