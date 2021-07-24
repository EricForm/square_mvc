<?php


namespace SquareMvc\Foundation;


class Session
{
    public const FLASH = '_flash';
    public const OLD = '_old';
    public const STATUS = '_status';
    public const ERRORS = '_errors';

    public static function init(): void
    {
        session_start();
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param bool $isFlash
     * @return mixed
     */
    public static function add(string $key, mixed $value, bool $isFlash = false): mixed
    {
        if ($isFlash) {
            return $_SESSION[static::FLASH][$key] = $value;
        }
        return $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public static function addFlash(string $key, mixed $value): mixed
    {
        return static::add($key, $value, true);
    }

    /**
     * @param string $key
     * @param bool $isFlash
     * @return mixed
     */
    public static function get(string $key, bool $isFlash = false): mixed
    {
        if ($isFlash) {
            return $_SESSION[static::FLASH][$key] ?? null;
        }
        return $_SESSION[$key] ?? null;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public static function getFlash(string $key): mixed
    {
        return static::get($key, true);
    }

    /**
     * @param string $key
     */
    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public static function resetFlash(): void
    {
        $_SESSION[static::FLASH] = [];
    }
}