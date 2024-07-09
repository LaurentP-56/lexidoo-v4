<?php

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
