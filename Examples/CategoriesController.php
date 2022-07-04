<?php

namespace App\Http\Controllers;

use App\Activity;
use App\ActivityRate;
use App\Category;
use App\Services\OffersFilter\FilterDirector\CategoryFilterDirector;
use App\Services\OffersFilter\FilterDirector\RegionFilterDirector;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::getActiveCountActivities(false, 0);

        return view('app.categories.index', compact('categories'));
    }

    public function show($alias)
    {
        $category = Category::whereAlias($alias)->with('categoryActivities.activity')->first();
        if(!isset($category))
            abort(404, 'Undefined category');

        $filters = [
            'regions' => [],
            'categories' => [],
            'collections' => [],
            'allocations' => [],
            'kinds' => [],
            'minimumAges' => [],
            'seasons' => [],
            'complexities' => [],
            'duration' => ['type'=>'days'],
            'price' => [],
            'groupSize' => [],
            'date' => [
                'type' => 'full',
                'date' => null,
                'month' => null,
                'flexibility' => 'flexible',
            ],
        ];
        $filters = array_merge_recursive($filters, ['categories' => [$category->id]]);

        $filter = new CategoryFilterDirector($filters);
        $filter_data = $filter->build();

        $filters = array_merge_recursive($filters, $filter_data['options']['range']);
        $options = array_merge_recursive(...array_values($filter_data['options']));

        $activities = $filter_data['data'];
        $activitiesIds = $activities->pluck('id');

        return view('app.categories.show', compact('activities', 'options', 'filters', 'activitiesIds','category'));
    }
}
