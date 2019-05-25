# swoft-laravel-validation
集成 laravel校验类至 swoft

php >7.2, swoft > v1.9 (暂不支持v2.x) 
## 技术细节
1. 技术目标:
    * 独立使用 laravel validation组件，文档和使用方式参考 laravel 社区文档
    * 在尽可能精简代码的前提下，尽可能迁移 laravel validation的功能：Validation, 多语言模板支持，通用校验方法
2. 实现:
    * 参照laravel validation的加载依赖，加载validation所需要的Validator Factory, Translator组件
    * Validator 类行为与laravel validator facade一致
## 安装
在composer.json require 中添加如依赖
```json
...
    "require": {
        ...
        "swoft-laravel/validation": "^1.0.3",
        ...
    }
....
```
更新依赖
```bash
# 更新所有依赖
composer update 
# 或者只更新生产环境依赖
composer update --no-dev
```
在根目录下新建文件结构:
```text
./resources/
└── lang
    ├── en
    └── zh
        ├── message.php
```
        
## 使用
详细用法可参考laravel官方文档: 
 * [英文文档](https://laravel.com/docs/5.8/validation)
 * [中文文档](https://learnku.com/docs/laravel/5.7/validation/3899)
```php 
use SwoftLaravel\Validation\Validator;
class Controller{
    public function test($request) {
        $data = $reqquest->post();
        $rules = [
            'mobile' => 'required|mobile',
            'email' => 'required|email'
        ];
        $errmap = [
            'mobile.required' => '手机号不能为空',
            'mobile.mobile' => '手机号格式不正确',
            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱格式不正确'
        ];
        $validator = Validator::make($data, $rules, $errmap);
        $error = null;
        if ($validator->fails()) {
            $validateErrors = $validator->messages();
            $error = [];
            foreach ($validateErrors->keys() as $field) {
                $msg = $validateErrors->get($field);
                $error[$field] = $msg[0];
            }
        }
    }
}
```
使用通用校验类
```php
use SwoftLaravel\Validation\Traits\TraitValidate;
class MockController{
    use TraitValidate;
    public function test($request) {
        $data = $reqquest->post();
        $rules = [
            'mobile' => 'required|mobile',
            'email' => 'required|email'
        ];
        $errmap = [
            'mobile.required' => '手机号不能为空',
            'mobile.mobile' => '手机号格式不正确',
            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱格式不正确'
        ];
        $errors = $this->validateError($data, $rules, $errmap);
        if ($errors !== null){
            return success_result($errors);
        }
    }
}
```
模板文件的使用
详细用法可参考官方文档：
* [英文文档](https://laravel.com/docs/5.7/localization)
* [中文文档](https://learnku.com/docs/laravel/5.7/localization/2266)
``` php
// 新增模板文件./resources/lang/zh/message.php
return [
    'system_busy'   => '系统繁忙, 请重试',
    'mobile'        => [
        'required'     => '请输入11位手机号',
        'invalid'      => '请输入11位手机号',
        'registered'   => '该账号已注册',
        'unregistered' => '该账号未注册'
    ],
    'vcode' => '你的注册码为
];
// 使用模板
$message = translator('message.systembusy');

```