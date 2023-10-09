<?php
namespace App\Repositories;

use App\Models\Setting;
use App\Enums\TypePaginate;

class SettingRepository implements BaseRepositoryInterface
{
    protected $setting;

    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    public function all()
    {
        return Setting::all();
    }

    public function find($id)
    {
        return Setting::find($id);
    }

    public function create(array $data)
    {
        return Setting::create($data);
    }

    public function update($id, array $data)
    {
        $setting = Setting::find($id);
        $setting->update($data);
        return $setting;
    }

    public function delete($id)
    {
        $setting = Setting::find($id);
        $setting->delete();
    }

    public function getSetting(){
        return $this->setting->first();
    }
}