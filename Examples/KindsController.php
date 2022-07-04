<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Kind;
use App\Region;
use App\Services\OffersFilter\FilterDirector\KindFilterDirector;
use App\Services\OffersFilter\FilterDirector\RegionFilterDirector;
use Illuminate\Http\Request;

class KindsController extends Controller
{
    public function index()
    {
        $kinds = Kind::getActiveCountActivities();

        return view('app.kinds.index', compact('kinds'));
    }

    public function show($alias)
    {
        $kind = Kind::with('activities')->whereAlias($alias)->first();
        if(!isset($kind))
            abort(404, 'Undefined region');

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
        $filters = array_merge_recursive($filters, ['kinds' => [$kind->id]]);

        $filter = new KindFilterDirector($filters);
        $filter_data = $filter->build();

        $filters = array_merge_recursive($filters, $filter_data['options']['range']);
        $options = array_merge_recursive(...array_values($filter_data['options']));

        $activities = $filter_data['data'];
        $activitiesIds = $activities->pluck('id');

        return view('app.kinds.show', compact('activities', 'options', 'filters', 'activitiesIds','kind'));
    }
}
