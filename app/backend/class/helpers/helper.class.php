<?php

// Helpers para ajudar no desenvolvimento
/**
 * @example $helper = new Helper(true); Ativa o debug
  */

class Helper {
    public $debug;

    // Ativa ou desativa o debug, padrão é falso
    public function __construct($active_debug = false) {
        $this->debug = $active_debug;
        $this->proj_debug_code();
    }

    public function proj_debug_code() {
        if ($this->debug) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        } else {
            ini_set('display_errors', 0);
            ini_set('display_startup_errors', 0);
            error_reporting(0);
        }
    }
}