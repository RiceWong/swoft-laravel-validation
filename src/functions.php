<?php
function translator($id = null, $replace = [], $locale = null) {
    return \SwoftLaravel\Validation\Validator::getTranslator()->trans($id, $replace, $locale);
}