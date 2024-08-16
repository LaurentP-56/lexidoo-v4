<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Level;
use App\Models\Mot;
use App\Models\SubCategory;
use App\Models\Theme;
use Maatwebsite\Excel\Concerns\ToModel;

class WordsImport implements ToModel
{
    public $levels         = [];
    public $themes         = [];
    public $categories     = [];
    public $sub_categories = [];

    public function __construct()
    {
        $this->levels         = Level::pluck('label', 'id')->all();
        $this->themes         = Theme::pluck('id', 'name')->all();
        $this->categories     = Category::pluck('id', 'name')->all();
        $this->sub_categories = SubCategory::pluck('id', 'name')->all();
    }

    public function model(array $row)
    {
        if ($row[0] == 'nom' && $row[1] == 'Traduction' && $row[2] == 'level') {
            return null;
        }

        if (isset($row['0']) && isset($row['1']) && isset($row['9']) && isset($row['10'])) {

            $level = [];
            foreach (['2', '3', '4', '5'] as $i) {
                if (isset($row[$i])) {
                    $level[] = $row[$i];
                }
            }

            if (!isset($this->themes[$row[9]])) {
                $theme = Theme::where('name', $row[9])->first();
                if (!$theme) {
                    $theme       = new Theme();
                    $theme->name = $row[9];
                    $theme->save();
                    $this->themes[$row[9]] = $theme->id;
                }
            }

            if (!isset($this->categories[$row[10]])) {
                $category = Category::where('name', $row[10])->first();
                if (!$category) {
                    $category           = new Category();
                    $category->theme_id = $this->themes[$row[9]];
                    $category->name     = $row[10];
                    $category->save();
                    $this->categories[$row[10]] = $category->id;
                }
            }

            if ($row[11] != '' && !isset($this->sub_categories[$row[11]])) {
                $sub_category = SubCategory::where('name', $row[11])->first();
                if (!$sub_category) {
                    $sub_category              = new SubCategory();
                    $sub_category->theme_id    = $this->themes[$row[9]];
                    $sub_category->category_id = $this->categories[$row[10]];
                    $sub_category->name        = $row[11];
                    $sub_category->save();
                    $this->sub_categories[$row[11]] = $sub_category->id;
                }
            }

            $mot = Mot::where('nom', $row[0])->where('theme_id', $this->themes[$row[9]])->first();
            if (!$mot) {
                $mot = new Mot();
            }

            $mot->nom                       = $row[0];
            $mot->traduction                = $row[1];
            $mot->levels                    = implode(',', $level);
            $mot->gratuit                   = isset($row[7]) ? $row[7] : "";
            $mot->probability_of_appearance = isset($row[8]) ? $row[8] : "";
            $mot->theme_id                  = $this->themes[$row[9]];
            $mot->category_id               = $this->categories[$row[10]];
            if ($row[11] != '') {
                $mot->sub_category_id = $this->sub_categories[$row[11]];
            }
            $mot->save();
            return $mot;
        }
    }
}
