<?php

namespace SwoftLaravel\Validation\Traits;

use SwoftLaravel\Validation\Validator;

trait TraitValidate {
    public function validateError($body, $rules, $errMap = []) {
        if ( empty($body) ){
            return [
                'body' => 'invalid body'
            ];
        }
        $validator = Validator::make($body, $rules, $errMap);
        $error = null;
        if ($validator->fails()) {
            $validateErrors = $validator->messages();
            $error = [];
            foreach ($validateErrors->keys() as $field) {
                $msg = $validateErrors->get($field);
                $error[$field] = $msg[0];
            }
        }
        return $error;
    }
}
