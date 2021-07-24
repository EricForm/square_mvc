<?php


namespace SquareMvc\Foundation;


use App\Models\User;

class Authentication
{
    protected const SESSION_ID = 'user_id';

    /**
     * @return bool
     */
    public static function check(): bool
    {
        return (bool) Session::get(static::SESSION_ID);
    }

    /**
     * @return bool
     */
    public static function checkIsAdmin(): bool
    {
        return static::check() && static::get()->role === 'admin';
    }

    /**
     * @param string $email
     * @param string $password
     * @return bool
     */
    public static function verify(string $email, string $password): bool
    {
        $user = User::where('email', $email)->first();
        return $user && password_verify($password, $user->password);
    }

    /**
     * @param int $id
     */
    public static function authenticate(int $id): void
    {
        Session::add(static::SESSION_ID, $id);
    }

    public static function logout(): void
    {
        Session::remove(static::SESSION_ID);
    }

    /**
     * @return int|null
     */
    public static function id(): ?int
    {
        return Session::get(static::SESSION_ID);
    }

    /**
     * @return User|null
     */
    public static function get(): ?User
    {
        return User::find(static::id());
    }
}