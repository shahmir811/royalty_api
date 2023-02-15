<?php

namespace App\Helper;

class Seed
{
    protected static $running = false;

    public static function isRunning()
    {
        return static::$running;
    }

    public function start()
    {
        static::$running = true;
    }

}