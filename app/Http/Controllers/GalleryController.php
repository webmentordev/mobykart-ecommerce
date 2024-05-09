<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    // List all gallery images
    public function index()
    {
        return view('dashboard.gallery.index', [
            'images' => Gallery::latest()->with('product')->get(),
            'products' => Product::latest()->get()
        ]);
    }

    // To upload gallery images
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'max:4500', 'mimes:png,jpg,webp,jpeg']
        ]);
        $filenamewithextension = $request->file('image')->getClientOriginalName();
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
        $extension = $request->file('image')->getClientOriginalExtension();
        $slug = str_replace(' ', '-', strtolower($filename)).'-'.time();
        $filenametostore = $slug.'.'.$extension;
        $link = $request->file('image')->storeAs('gallery', $filenametostore);
        Gallery::create([
            'image' => $link,
            'slug' => $slug,
            'product_id' => $request->product,
        ]);
        return back()->with('success', 'Gallery image has been uploaded!');
    }

    // To delete gallery image
    public function delete(Gallery $gallery)
    {
        Storage::disk('public_disk')->delete($gallery->image);
        $gallery->delete();
        return back()->with('success', 'Gallery image has been deleted!');
    }

    // To change gallery image status
    public function status(Gallery $gallery)
    {
        $gallery->is_active = !$gallery->is_active;
        $gallery->save();
        return back()->with('success', 'Gallery image status has been updated!');
    }
}
