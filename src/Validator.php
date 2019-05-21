<?php


namespace SwoftLaravel\Validation;
use Illuminate\Translation\FileLoader;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use Swoft\Helper\DirHelper;


/**
 * Laravel 校验类，用法参考下面的链接
 * @package App\Lib\Validators
 * 英文文档 https://laravel.com/docs/5.8/validation
 * 中文文档 https://learnku.com/docs/laravel/5.7/validation/3899
 */
class Validator {
    /**
     * @var
     */
    protected static $factory = null;
    protected static $translator = null;

    public static function getInstance() {
        if (self::$factory === null) {
            self::$factory = new Factory(self::getTranslator());
        }
        return self::$factory;
    }
    public static function getTranslator(){
        if (self::$translator == null){
            $translatorPath = BASE_PATH . '/resources/lang';
            $defaultLang = 'zh';
            $translationLoader = new FileLoader(new Filesystem, $translatorPath);
            self::$translator = new Translator($translationLoader, $defaultLang);
        }
        return self::$translator;
    }
    public static function __callStatic($method, $arguments) {
        return call_user_func_array([self::getInstance(), $method], $arguments);
    }
}