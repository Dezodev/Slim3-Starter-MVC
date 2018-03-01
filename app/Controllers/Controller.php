<?php

namespace App\Controllers;
use App\Models\Setting;

class Controller
{
    protected $container;

    public function __construct($container) {
        $this->container = $container;

        $this->init();
    }

    public function init() {
        $baseSettings = [
            'maintenance_mode' => [
                'name' => 'Mode maintenance',
                'value' => '0'
            ],
            'site_name' => [
                'name' => 'Nom du site',
                'value' => 'Slim starter MVC'
            ],
            'site_baseline' => [
                'name' => 'Slogan du site',
                'value' => ''
            ],
            'site_description' => [
                'name' => 'Description du site',
                'value' => ''
            ],
        ];

        foreach ($baseSettings as $slug => $setting) {
            if (Setting::where('slug', $slug)->count() == 0) {
                Setting::create([
                    'slug' => $slug,
                    'name' => $setting['name'],
                    'value' => $setting['value'],
                ]);
            }
        }

        $this->app_settings = Setting::all()->keyBy('slug')->toArray();
    }

    public function __get($proprety) {
        if($this->container->{$proprety}){
            return $this->container->{$proprety};
        }
    }
}
