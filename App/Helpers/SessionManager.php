<?php

namespace App\Helpers;

class SessionManager{

    protected static $sessionStarted = false;
    protected static $sessionIdRegenerated = false;


    public function __construct()
    {
    }

    public static function start()
    {
        // if (!self::$sessionStarted) {
        //     session_start();
        //     self::$sessionStarted = true;
        // }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set(string $name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public static function get(string $name, $default = null)
    {
        return $_SESSION[$name] ?? $default;
    }

    public static function remove(string $name)
    {
        unset($_SESSION[$name]);
    }

    public static function clear()
    {
        session_unset();
    }

    public static function regenerate(bool $destroy = true)
    {
        if (!self::$sessionIdRegenerated) {
            session_regenerate_id($destroy);
            self::$sessionIdRegenerated = true;
        }
    }

    public static function setAuthenticated(bool $bool)
    {
        self::set('_authenticated', $bool);
        self::regenerate();
    }

    public static function isAuthenticated(): bool
    {
        return self::get('_authenticated', false);
    }

    public static function destroy(){
        session_destroy();
    } 
    
}