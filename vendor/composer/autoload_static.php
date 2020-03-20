<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit519e29b320ae7c7817f0a9da2386c714
{
    public static $files = array (
        'bd9634f2d41831496de0d3dfe4c94881' => __DIR__ . '/..' . '/symfony/polyfill-php56/bootstrap.php',
        '9b552a3cc426e3287cc811caefa3cf53' => __DIR__ . '/..' . '/topthink/think-helper/src/helper.php',
        'cc56288302d9df745d97c934d6a6e5f0' => __DIR__ . '/..' . '/topthink/think-queue/src/common.php',
        '1cfd2761b63b0a29ed23657ea394cb2d' => __DIR__ . '/..' . '/topthink/think-captcha/src/helper.php',
        'ea51e7f80936725691663347d5b38bd9' => __DIR__ . '/..' . '/topthink/think-swoole/src/command.php',
    );

    public static $prefixLengthsPsr4 = array (
        't' => 
        array (
            'think\\swoole\\' => 13,
            'think\\composer\\' => 15,
            'think\\captcha\\' => 14,
            'think\\' => 6,
        ),
        'a' => 
        array (
            'app\\' => 4,
        ),
        'X' => 
        array (
            'XCron\\' => 6,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Util\\' => 22,
            'Symfony\\Polyfill\\Php56\\' => 23,
            'SuperClosure\\' => 13,
        ),
        'P' => 
        array (
            'PhpParser\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'think\\swoole\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-swoole/src',
        ),
        'think\\composer\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-installer/src',
        ),
        'think\\captcha\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-captcha/src',
        ),
        'think\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-helper/src',
            1 => __DIR__ . '/..' . '/topthink/think-queue/src',
        ),
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/application',
        ),
        'XCron\\' => 
        array (
            0 => __DIR__ . '/..' . '/xavier/xcron-expression/src/Cron',
        ),
        'Symfony\\Polyfill\\Util\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-util',
        ),
        'Symfony\\Polyfill\\Php56\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-php56',
        ),
        'SuperClosure\\' => 
        array (
            0 => __DIR__ . '/..' . '/jeremeamia/superclosure/src',
        ),
        'PhpParser\\' => 
        array (
            0 => __DIR__ . '/..' . '/nikic/php-parser/lib/PhpParser',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'PHPExcel' => 
            array (
                0 => __DIR__ . '/..' . '/phpoffice/phpexcel/Classes',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit519e29b320ae7c7817f0a9da2386c714::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit519e29b320ae7c7817f0a9da2386c714::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit519e29b320ae7c7817f0a9da2386c714::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}