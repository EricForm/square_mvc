<?php


namespace SquareMvc\Foundation;


use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class View
{
    public static function render(string $view, array $data = []): void
    {
        $view = str_replace('.', DIRECTORY_SEPARATOR, $view);

        if (!static::viewExists($view)) {
            throw new \InvalidArgumentException(
                sprintf('The view %s does not exist!', $view)
            );
        }

        $twig = static::initTwig();

        echo $twig->render(
            sprintf('%s.%s', $view, Config::get('twig.template_extension')),
            $data
        );
    }

    /**
     * @param string $view
     * @return bool
     */
    protected static function viewExists(string $view): bool
    {
        return file_exists(
            sprintf(
                '%s'
                . DIRECTORY_SEPARATOR . 'resources'
                . DIRECTORY_SEPARATOR . 'views'
                . DIRECTORY_SEPARATOR . '%s.%s',
                ROOT, $view, Config::get('twig.template_extension'))
        );
    }

    /**
     * @return Environment
     */
    protected static function initTwig(): Environment
    {
        $loader = new FilesystemLoader(ROOT . DIRECTORY_SEPARATOR .'resources' . DIRECTORY_SEPARATOR .'views');
        $twig = new Environment($loader, [
            'cache' => ROOT . DIRECTORY_SEPARATOR .'cache'. DIRECTORY_SEPARATOR .'twig',
            'auto_reload' => true,
        ]);
        foreach (Config::get('twig.functions') as $helper) {
            $twig->addFunction(new TwigFunction($helper, $helper));
        }
        return $twig;
    }

    /**
     * @return string
     */
    public static function csrfField(): string
    {
        return sprintf('<input type="hidden" name="_token" value="%s">', Session::get('_token'));
    }

    /**
     * @param string $httpMethod
     * @return string
     */
    public static function method(string $httpMethod): string
    {
        return sprintf('<input type="hidden" name="_method" value="%s">', $httpMethod);
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public static function old(string $key, mixed $default = null): mixed
    {
        $old = Session::getFlash(Session::OLD);
        return $old[$key] ?? $default;
    }
}