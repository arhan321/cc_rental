<?php

namespace App\Http\Controllers;

use App\Models\Kostum;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        // Fetch categories from the database
    $categories = Category::all();

    // If a category is selected, filter the kostums
    $kostums = Kostum::with('category');

    // Filter by selected category if provided
    if ($request->has('filterCategory') && $request->filterCategory != 'Semua') {
        $kostums = $kostums->where('category_id', $request->filterCategory);
    }

    // Get the filtered kostums
    $kostums = $kostums->get();

    

        // Pass the data to the view
        return view('frontend.index', compact('kostums', 'categories'));
    }
}
