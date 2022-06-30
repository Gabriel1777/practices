<?php


namespace App\Services;


use Kreait\Firebase\Factory;
use Kreait\Firebase\DynamicLink\IOSInfo;
use Kreait\Firebase\DynamicLink\AndroidInfo;
use Kreait\Firebase\DynamicLink\CreateDynamicLink;

class DynamicLinkService
{

    private $firebase;

    public function __construct()
    {
        $this->firebase = (new Factory)->withServiceAccount(__DIR__ . '/../../FIREBASE_CREDENTIALS.json');
    }

    public function createDynamicLink($url, $webUrl = null)
    {
        try {
            $iosConfig = IOSInfo::new()
                ->withBundleId(config('firebase.ios.bundle_id'));

            if ($webUrl)
                $iosConfig = $iosConfig->withFallbackLink($webUrl);
            else
                $iosConfig = $iosConfig->withFallbackLink(
                    'https://apps.apple.com/us/app/app-example/id' . config('firebase.ios.app_store_id')
                );

            $androidConfig = AndroidInfo::new()
                ->withPackageName(config('firebase.android.package_name'));

            if ($webUrl)
                $androidConfig = $androidConfig->withFallbackLink($webUrl);

            $dynamic = CreateDynamicLink::forUrl($url)
                ->withShortSuffix()
                ->withIOSInfo($iosConfig)
                ->withAndroidInfo($androidConfig);
            return $this->firebase
                ->createDynamicLinksService(config('firebase.dynamic_links.domain'))
                ->createDynamicLink($dynamic);
        } catch (CreateDynamicLink\FailedToCreateDynamicLink $e) {
            throw new \Exception($e->getMessage());
        }
    }
}