<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite6b9dded296e936d7545b06896c169f8
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'DrewM\\MailChimp\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'DrewM\\MailChimp\\' => 
        array (
            0 => __DIR__ . '/..' . '/drewm/mailchimp-api/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite6b9dded296e936d7545b06896c169f8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite6b9dded296e936d7545b06896c169f8::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
