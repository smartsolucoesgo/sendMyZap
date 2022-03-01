<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4d8e47130bf96c218cf2d6620e1862b6
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SmartSolucoes\\' => 14,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SmartSolucoes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/application',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4d8e47130bf96c218cf2d6620e1862b6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4d8e47130bf96c218cf2d6620e1862b6::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit4d8e47130bf96c218cf2d6620e1862b6::$classMap;

        }, null, ClassLoader::class);
    }
}
