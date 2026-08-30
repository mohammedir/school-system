<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Models\Lookups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class LookupsController extends Controller
{
    public function get_children_by_parent(Request $request)
    {
        $obj = Lookups::query()->find($request->input("id"));

        // الخيار الأول "اختر"
        $firstOption = '<option value="">-- اختر --</option>';

        // باقي الخيارات من الـ Blade
        $childrenOptions = View::make('ajax.lookups_options', ["options" => $obj->children])->render();

        return response()->json([
            "children" => $firstOption . $childrenOptions,
        ]);
    }

}
