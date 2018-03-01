<?php

namespace App\Controllers\Admin;
use App\Models\Setting;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class SettingController extends Controller {
    public function index($request, $response, $args) {
        return $this->view->render($response, 'admin/setting/index.twig');
    }

    public function save($request, $response, $args) {
        $form = $request->getParams();
        $html_supp = '';

        if($this->app_settings['site_name']['value'] != $form['site_name']){
            Setting::find($this->app_settings['site_name']['id'])->update([
                'value' => $form['site_name']
            ]);
        }

        if($this->app_settings['site_baseline']['value'] != $form['site_baseline']){
            Setting::find($this->app_settings['site_baseline']['id'])->update([
                'value' => $form['site_baseline']
            ]);
        }

        if($this->app_settings['site_description']['value'] != $form['site_description']){
            Setting::find($this->app_settings['site_description']['id'])->update([
                'value' => $form['site_description']
            ]);
        }

        if($this->app_settings['maintenance_mode']['value'] != $form['maintenance_mode']){
            Setting::find($this->app_settings['maintenance_mode']['id'])->update([
                'value' => $form['maintenance_mode']
            ]);
        }

        // $html_supp .= '==<br />'. var_export($form['maintenance_mode'], 1) .'<br />==';

        $this->flash->addMessage('success', 'Les réglages ont bien été sauvegardés.<br/>'.$html_supp);
        return $response->withRedirect($this->router->pathFor('admin_setting'));
    }
}
