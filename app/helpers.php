<?php

use App\Models\LogActivity;
use hisorange\BrowserDetect\Parser as Browser;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Request;

function enkrip($value)
{
    try {
        return Crypt::encryptString($value);
    } catch (EncryptException $e) {
        return $e->getMessage();
    }
}

function dekrip($value)
{
    try {
        return Crypt::decryptString($value);
    } catch (DecryptException $e) {
        return $e->getMessage();
    }
}

function createLogActivity($activity)
{
    $log = [
        'ip_access' => Request::ip(),
        'id_user' => Auth::check() ? Auth::user()->id : 0,
        'activity_content' => $activity,
        'url' => Request::fullUrl(),
        'operating_system' => Browser::platformName(),
        'device_type' => Browser::deviceType(),
        'browser_name' => Browser::browserName(),
        'method' => Request::method(),
    ];
    LogActivity::create($log);
}
