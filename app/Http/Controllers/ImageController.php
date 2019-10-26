<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageName;
use App\Models\Image as Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

/**
 * Class ImageController
 * @package App\Http\Controllers
 */
class ImageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $images = Photo::where('user_id', Auth::id())->get();
        return view('image.index', compact('images'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('image.upload');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $images = $request->file('file');

        if (!is_array($images)) {
            $images = [$images];
        }

        foreach ($images as $image) {
            $extension = $image->getClientOriginalExtension();

            $fileName = md5(Str::random(20)) . '.' . $extension;

            // File save
            $originalFile = Image::make($image->getRealPath());

            $originalFile->resize(100, '', function ($c) {
                $c->aspectRatio();
                $c->upsize();
            })->save(config('app.local_path') . $fileName);

            $photo = new Photo();
            $photo->user_id = Auth::id();
            $photo->name = $fileName;
            $photo->save();
        }

        return redirect()->route('photos')
            ->with('info','Images have been saved Successfully');
    }

    public function destroy(ImageName $request)
    {
        $filename =  $request->get('filename');

        Photo::where([
            ['user_id', Auth::id()],
            ['name', $filename]
        ])->delete();

        $path=config('app.local_path') . $filename;

        if (file_exists($path)) {
            unlink($path);

            return response()->json(['message' => 'File has been successfully deleted'], 200);
        }

        return response()->json(['message' => 'File not found']);
    }

    /**
     * @param ImageName $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setProfile(ImageName $request)
    {
        $photo = Photo::where([
            ['user_id', Auth::id()],
            ['profile_pic', 1]
        ])->first();

        if(!empty($photo)) {
            $photo->profile_pic = null;
            $photo->save();
        }

        $filename =  $request->get('filename');

        Photo::where([
            ['user_id', Auth::id()],
            ['name', $filename]
        ])->update(array('profile_pic' => 1));

        return response()->json(['message' => 'Image has been set as profile image'],200);
    }
}
