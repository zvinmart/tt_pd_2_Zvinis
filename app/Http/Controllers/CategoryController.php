<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function list()
    {
        $items = Category::orderBy('name', 'asc')->get();
        return view(
            'category.list',
            [
                'title' => 'Category',
                'items' => $items
            ]
        );
    }

    public function create()
    {
        return view(
            'category.form',
            [
                'title' => 'Pievienot kategoriju',
                'category' => new Category()
            ]
        );
    }

    public function put(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);
        $category = new Category();
        $category->name = $validatedData['name'];
        $category->save();
        return redirect('/categories');
    }

    public function update(Category $category)
    {
        return view(
            'category.form',
            [
                'title' => 'Rediģēt kategoriju',
                'category' => $category
            ]
        );
    }

    public function patch(Category $category, Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);
        $category->name = $validatedData['name'];
        $category->save();
        return redirect('/categories');
    }

    public function delete(Category $category)
    {
        $category->delete();
        return redirect('/categories');
    }



}