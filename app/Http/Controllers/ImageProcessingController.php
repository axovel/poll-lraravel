<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\Response;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\File;

use Validator;

class ImageProcessingController extends Controller
{

    /**
     * @param Request $request
     * @return int
     */
    public function postUploadAdImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $file           = $request->file('image');
            $uniqueFileName = md5(uniqid());

            $validator = Validator::make(
                $request->all(),
                ['image'          => 'required|mimes:jpg,jpeg,png,bmp|max:2000'],
                ['image.required' => 'Please upload an image',
                 'image.mimes'    => 'Only jpeg,png and bmp images are allowed',
                 'image.max'      => 'Sorry! Maximum allowed size for an image is 2MB'
                ]
            );

            if (!$validator->fails()) {
                if (!File::exists(public_path() . '/media/images/')) {
                    File::makeDirectory(public_path() . '/media');
                }
                $fileName = $uniqueFileName . '.' . $file->getClientOriginalExtension();
                $file->move(config('image.temp_image_path'), $fileName);
                return view('blocks.image-preview', compact('fileName'));
            }

            return response()->json(['success' => false, 'errors' => $validator->messages()->toArray()]);
        }
    }
}
