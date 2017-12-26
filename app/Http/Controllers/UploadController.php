<?php

namespace App\Http\Controllers;
 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UploadController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function imageUpload(Request $request)
    {
        $file = Input::file('file');
        $extension = $file->getClientOriginalExtension();
        $imageName = $file->getFilename().'.'.$extension;
        $location = 'images/recipes/'.$imageName;

        Storage::disk('upload')->put($location,  File::get($file));

        return Response::json(array('status'=>'success', 'data' => 'uploads/'.$location));
    }
}
