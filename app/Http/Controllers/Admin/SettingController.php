<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SettingRepository;
use App\Http\Requests\Admin\UpdateSettingRequest;


class SettingController extends Controller
{
    protected $settingRepository;

    public function __construct(SettingRepository $settingRepository )
    {
        $this->settingRepository = $settingRepository;
    }

    public function settings(){
        $setting = $this->settingRepository->getSetting();
        return $setting;
    }

    public function update(UpdateSettingRequest $request, $id){
        $data = $request->all();
        $setting = $this->settingRepository->update($id,$data);

        return response()->json(['success' => true]);
    }
}
