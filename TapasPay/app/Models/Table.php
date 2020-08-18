<?php

namespace App\Models;

class Table {

    public $url;
    public $number;

    public function __construct($number, $url) {
        $this->url = $url;
        $this->number = $number;
    }

}
