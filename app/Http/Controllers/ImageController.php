<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    // List all images
    public function index()
    {
        return view('dashboard.images.index', [
            'images' => Image::latest()->get()
        ]);
    }

    // CKEditor use it to upload images
    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            $filenamewithextension = $request->file('upload')->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $slug = str_replace(' ', '-', strtolower($filename)).'-'.time();
            $filenametostore = $slug.'.'.$extension;
            $link = $request->file('upload')->storeAs('images', $filenametostore);
            Image::create([
                'image' => $link,
                'slug' => $slug
            ]);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/images/'.$filenametostore);
            $msg = 'Image successfully uploaded';
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }
    }

    // To manually upload images
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
        $link = $request->file('image')->storeAs('images', $filenametostore);
        Image::create([
            'image' => $link,
            'slug' => $slug
        ]);
        return back()->with('success', 'Image has been uploaded!');
    }

    // To delete images
    public function delete(Image $image)
    {
        Storage::disk('public_disk')->delete($image->image);
        $image->delete();
        return back()->with('success', 'Image has been deleted!');
    }
}