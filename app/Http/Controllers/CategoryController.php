<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function GetCategories()
    {
        $data = Category::all();
        return response()->json($data);

    }
}
