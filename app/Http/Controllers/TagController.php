<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    // List all tags
    public function index()
    {
        return view('dashboard.tags.index', [
            'tags' => Tag::latest()->get()
        ]);
    }

    // To create new tag
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255', 'string', 'unique:tags,name']
        ]);
        $array = explode(',', $request->name);
        foreach($array as $item){
            Tag::create([
                'name' => $item,
                'slug' => str_replace(' ', '-', strtolower($item))
            ]);
        }
        return back()->with('success', 'Tag(s) has been created!');
    }

    // To delete tag
    public function delete(Tag $tag)
    {
        $tag->delete();
        return back()->with('success', 'Tag has been deleted!');
    }
}
