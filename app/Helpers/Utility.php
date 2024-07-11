<?php

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Theme;

if (!function_exists('getThemes')) {
    /**
     * Get themes list
     *
     * @return array
     * @author Bhavesh Vyas
     */
    function getThemes()
    {
        return Theme::pluck('name', 'id')->all();
    }
}

if (!function_exists('getCategory')) {
    /**
     * Get themes list
     *
     * @return array
     * @author Bhavesh Vyas
     */
    function getCategory(int $themeId = null)
    {
        if ($themeId !== null) {
            return Category::where('theme_id', $themeId)->pluck('name', 'id')->all();
        }
        return Category::pluck('name', 'id')->all();
    }
}

if (!function_exists('getSubCategory')) {
    /**
     * Get themes list
     *
     * @return array
     * @author Bhavesh Vyas
     */
    function getSubCategory(int $categoryId = null)
    {
        if ($categoryId !== null) {
            return SubCategory::where('category_id', $categoryId)->pluck('name', 'id')->all();
        }
        return SubCategory::pluck('name', 'id')->all();
    }
}
