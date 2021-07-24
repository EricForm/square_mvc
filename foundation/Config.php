<?php


namespace SquareMvc\Foundation;


class Config
{
    /*
       PhpStorm @noinspection PhpIncludeInspection
       Supprime l'avertissement "Dynamic include expression 'require $path' is not analysed."
       https://stackoverflow.com/questions/18530502/phpstorm-cant-analyse-a-path-from-a-variable
    */

    /**
     * @noinspection PhpIncludeInspection
     * @param string $config
     * @return mixed
     */
    public static function get(string $config): mixed
    {
        [$file, $key] = static::getFileAndKey($config);

        $path = static::getPath($file);
        $config = require $path;

        return $config[$key] ?? null;
    }

    /**
     * @param string $config
     * @return array
     */
    protected static function getFileAndKey(string $config): array
    {
        if (!preg_match('/^[a-z_]+\.[a-z_]+$/i', $config)) {
            throw new \InvalidArgumentException(
                sprintf('Bad format (%s instead of file.key (letters and _ accepted))', $config)
            );
        }
        return explode('.', $config);
    }

    /**
     * @param string $file
     * @return string
     */
    protected static function getPath(string $file): string
    {
        $path = sprintf('%s' . DIRECTORY_SEPARATOR
            . 'config' . DIRECTORY_SEPARATOR
            . '/%s.php', ROOT, $file);
        if (!file_exists($path)) {
            throw new \InvalidArgumentException('The configuration file does not exist!');
        }
        return $path;
    }
}