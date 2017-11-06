<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of String
 *
 */
class Str {

  static function str_random($length) {
        $string = "0123456789azertyuiopqsdfghjklmwxcvbn";
        return substr(str_shuffle(str_repeat($string, $length)), 0, $length);
    }

}
