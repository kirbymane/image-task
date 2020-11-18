<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class PictureController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $images = Image::where('available_at', '<=', date('Y-m-d'))
            ->paginate(5);

        foreach ($images as $img) {
            $img->uploaded_by = User::where('id', $img->user_id)
                ->firstOrFail()['name'];
        }

        return view('images.home', [
            'images' => $images
        ]);
    }

    public function createFromLocal()
    {
        return view('images.upload.local');
    }

    public function createFromRemote()
    {
        return view('images.upload.remote');
    }

    public function storeLocal()
    {
        $attributes = request()->validate([
            'available_at' => [
                'required',
                'date',
                'after_or_equal:today'
            ],
            'path' => [
                'required',
                'file',
            ]
        ]);

        if (request('path')) {
            $attributes['path'] = request()
                ->file('path')
                ->store('images/' . date('Y') . '/' . date('m') . '/' . date('d'));
        }

        $attributes['user_id'] = auth()->id();

        Image::create($attributes);

        return redirect()
            ->route('home');
    }

    public function storeRemote()
    {
        $attributes = request()->validate([
            'path' => [
                'required',
                'url'
            ],
            'available_at' => [
                'required',
                'date',
                'after_or_equal:today'
            ]
        ]);

        $info = pathinfo($attributes['path']);
        $contents = file_get_contents($attributes['path']);
        $file = $info['basename'];
        file_put_contents($file, $contents);
        $uploaded_file = new UploadedFile($file, $info['basename']);;
        $uploaded_file->store('images/' . date('Y') . '/' . date('m') . '/' . date('d'));

        Image::create([
            'user_id' => auth()->id(),
            'available_at' => $attributes['available_at'],
            'path' => 'images/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $uploaded_file->hashName()
        ]);

        return redirect()
            ->route('home');
    }

    public function displayImage($id)
    {
        $img = Image::where('id', $id)->firstOrFail();

        if ($img->available_at == date('Y-m-d')) {
            return Storage::get($img->path);
        } else {
            return false;
        }
    }
}
