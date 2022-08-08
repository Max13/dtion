<?php

/** Interface must not be loaded if already existant (PHP<8.0) */
if(!interface_exists('Stringable')) {
    /**
     * Interface to store stringable elements in Dtion
     */
    interface Stringable
    {
        /**
         * Implicitely implements PHP Stringable interface
         * for PHP>=8.0 .
         *
         * @return string
         */
        public function __toString() : string;
    }
}
