<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{

    public function setting(Request $request)
    {
        if ($request->has('tab')) {
            $tab = $request->tab;
        } else {
            $tab = 'openai';
        }
        $aiModels = [
            'text-ada-001'=>'Ada (GPT 3)',
            'text-babbage-001'=>'Babbage (GPT 3)',
            'text-curie-001'=>'Curie (GPT 3)',
            'text-davinci-003'=>'Davinci (GPT 3)',
            'gpt-3.5-turbo'=>'ChatGPT (3.5 Turbo)',
            // 'gpt-4'=>'GPT 4 (8K)',
            // 'gpt-4-32k'=>'GPT 4 (32K)',
            ];
        return view('admin.setting.setting', compact('tab','aiModels'));
    }

    public function openAiStore(Request $request)
    {
        overWriteEnvFile('OPENAI_API_KEY', $request->OPENAI_API_KEY);
        writeConfig('open_ai_model', $request->open_ai_model);
        toast('Open Ai API settings is saved', 'success');
        return redirect()->route('setting', ['tab' => "openai"]);
    }

    public function tawkToStore(Request $request)
    {
        writeConfig('tawk_direct_link', $request->tawk_direct_link);
        writeConfig('tawk_to', $request->tawk_to);
        $fileName = base_path('resources/views/layouts/tawk_to.blade.php');
        $fileContents = $request->code;
        File::put($fileName, $fileContents);
        toast('Tawk to is setup', 'success');
        return redirect()->route('setting', ['tab' => "tawkto"]);
    }

    public function socialStore(Request $request)
    {
        overWriteEnvFile('GOOGLE_CLIENT_ID', $request->GOOGLE_CLIENT_ID);
        overWriteEnvFile('GOOGLE_CLIENT_SECRET', $request->GOOGLE_CLIENT_SECRET);
        overWriteEnvFile('GOOGLE_REDIRECT_URL', $request->GOOGLE_REDIRECT_URL);

        toast('Google Login Credential is setup', 'success');
        return redirect()->route('setting', ['tab' => "login"]);
    }


    public function seoStore(Request $request)
    {
        if ($request->has('meta_key')) {
            writeConfig('meta_key', $request->meta_key);
        }

        if ($request->has('meta_title')) {
            writeConfig('meta_title', $request->meta_title);
        }

        if ($request->has('meta_desc')) {
            writeConfig('meta_desc', $request->meta_desc);
        }

        if ($request->hasFile('meta_image')) {
            $imag = fileUpload($request->file('meta_image'), 'seo', '');
            writeConfig('meta_image', $imag);
        }

        toast('Seo Setup Succssfully', 'success');
        return redirect()->route('setting', ['tab' => "seo"]);
    }

    public function smtpStore(Request $request)
    {

        foreach ($request->types as $key => $type) {
            overWriteEnvFile($type, $request[$type]);
        }

        toast('Mail setup  successfully', 'success');
        return redirect()->route('setting', ['tab' => "smtp"]);
    }

    public  function siteSettingUpdate(Request $request)
    {

        // return $request;
        if ($request->hasFile('logo')) {
            $oldFile = readConfig('logo');
            fileDelete($oldFile);
            $logo = fileUpload($request->file('logo'), 'site', 'logo');
            writeConfig('logo', $logo);
        }
        if ($request->hasFile('icon')) {
            $oldFile = readConfig('icon');
            fileDelete($oldFile);
            $icon = fileUpload($request->file('icon'), 'site', 'icon');
            // Icon generate for PWA
            writeConfig('icon', $icon);
            iconGenerate($icon);
        }

        if ($request->has('name')) {
            writeConfig($request->type_name, $request->name);
            writeConfig('name', $request->name);
        }

        if ($request->has('heading_title')) {
            writeConfig('heading_title', $request->heading_title);
        }
        if ($request->has('footer')) {
            writeConfig($request->type_footer, $request->footer);
        }

        if ($request->has('fb')) {
            writeConfig($request->type_fb, $request->fb);
        }

        if ($request->has('tw')) {
            writeConfig($request->type_tw, $request->tw);
        }

        if ($request->has('instagram')) {
            writeConfig($request->type_insta, $request->instagram);
        }

        if ($request->has('address')) {
            writeConfig($request->type_address, $request->address);
        }

        if ($request->has('number')) {
            writeConfig($request->type_number, $request->number);
        }

        if ($request->has('mail')) {
            writeConfig($request->type_mail, $request->mail);
        }
        toast('Site Setting Is  Setup  Successfully', 'success');
        return redirect()->route('setting', ['tab' => "cms"]);
    }





    public function pwaSetupStore(Request $request)
    {



        if ($request->has('pwa_active')) {
            writeConfig('pwa_active', $request->pwa_active);
        }

        if ($request->has('pwa_name')) {
            // setSystemSetting('pwa_name', $request->pwa_name);
            writePwaConfig('name', $request->pwa_name);
        }

        if ($request->has('short_name')) {
            // setSystemSetting('short_name', $request->short_name);
            writePwaConfig('manifest.short_name', $request->short_name);
        }

        if ($request->has('background_color')) {
            // setSystemSetting('background_color', $request->background_color);
            writePwaConfig('manifest.background_color', $request->background_color);
        }

        if ($request->has('theme_color')) {
            // setSystemSetting('theme_color', $request->theme_color);
            writePwaConfig('manifest.theme_color', $request->theme_color);
        }
        Artisan::call('optimize:clear');

        toast('Pwa Is  Setup  Successfully', 'success');
        return redirect()->route('setting', ['tab' => "pwa"]);
    }
}
