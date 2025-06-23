<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmtpSetting;
use App\Models\SiteSetting;
use Intervention\Image\Facades\Image;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class SettingController extends Controller
{
    public function SmtpSetting(){
        $smtp = SmtpSetting::find(1);
        return view('backend.setting.smtp_update', compact('smtp'));
    }

    public function SmtpUpdate(Request $request){
        $smtp_id = $request->id;
        SmtpSetting::find($smtp_id)->update([
            'mailer' => $request->mailer,
            'host' => $request->host,
            'port' => $request->port,
            'username' => $request->username,
            'password' => $request->password,
            'encryption' => $request->encryption,
            'from_address' => $request->from_address,
        ]);

        $notification = array(
            'messsage' => 'Cài đặt SMTP đã được cập nhật thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Cài đặt SMTP đã được cập nhật thành công')->with('alert-type', 'success');
    }

    public function SiteSetting(){
        $site = SiteSetting::find(1);
        return view('backend.site.site_update', compact('site'));
    }

    public function SiteUpdate(Request $request)
    {
        $site_id = $request->id;
        $data = [
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'copyright' => $request->copyright,
        ];

        if ($request->hasFile('logo')) {
            $uploadResult = Cloudinary::upload($request->file('logo')->getRealPath(), [
                'folder' => 'site_settings',
                'transformation' => [
                    'width' => 110,
                    'height' => 44,
                    'crop' => 'fill',
                    'gravity' => 'auto',
                ],
                'resource_type' => 'image',
            ]);

            $data['logo'] = $uploadResult->getSecurePath(); // URL logo từ Cloudinary
        }

        SiteSetting::findOrFail($site_id)->update($data);

        return redirect()->back()->with([
            'message' => 'Cài đặt trang web đã được cập nhật thành công',
            'alert-type' => 'success'
        ]);
    }

}
