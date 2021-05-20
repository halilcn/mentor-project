<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\MeSettingsRequest;
use App\Http\Resources\MeSettingsResource;
use App\Http\Resources\MeUpdatedSettingResource;

//facade
use App\Jobs\DeleteProfileImage;
use App\Jobs\UploadProfileImage;
use App\Services\ApiStorageService;

use Illuminate\Http\Request;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Support\Facades\Bus;
use Intervention\Image\Facades\Image;


class MeSettingResourceController extends Controller
{

    public function index(Request $request)
    {
        return new MeSettingsResource($request->user());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }


    public function store(MeSettingsRequest $request)
    {
        if ($request->hasFile('image_file')) {
            UploadProfileImage::dispatchSync($request->user(), $request->file('image_file')->getRealPath());
            /*  Bus::chain(
                  [
                      //   new DeleteProfileImage($request->user()),
                      //new UploadProfileImage($request->file('image_file')->getRealPath())
                  ]
              )->dispatch();*/
        }

        if ($request->has('cv_file')) {
            //İş
        }

        $request->user()->update(
            collect($request->validated())->except('image_file', 'cv_file')->toArray()
        );

        return response(['status' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }


    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
