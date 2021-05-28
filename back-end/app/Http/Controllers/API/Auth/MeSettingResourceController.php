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
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use function PHPUnit\Framework\returnArgument;


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
        $validated = collect($request->validated());

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('user-profile', 'temporary');
            //yanlış!
            (new ApiStorageService())->put(
                '../storage/app/public/temporary/'.$path,
                [
                    'folder' => 'users-profile',
                    'resource_type' => 'image',
                    'transformation' => [
                        'width' => 256,
                        'height' => 256
                    ]
                ]
            );
            /* Bus::chain(
                 [
                     new DeleteProfileImage($request->user()),
                     new UploadProfileImage($request->user(), $path)
                 ]
             )->dispatch();*/
        }

        if ($request->hasFile('cv_file')) {
            Storage::delete($request->user()->cv_path);
            $validated->put('cv_path', $request->file('cv_file')->store('cv'));
        }

        $request->user()->update(
            $validated->except('image_file', 'cv_file')->toArray()
        );

        return MeSettingsResource::make($request->user());
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
