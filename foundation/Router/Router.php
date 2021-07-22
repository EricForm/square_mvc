<?php


namespace SquareMvc\Foundation\Router;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class Router
{
    protected RouteCollection $routes;
    protected RequestContext $context;
    protected Request $request;
    protected array $params;
    protected string $controller;
    protected string $method;


    /**
     * Router constructor.
     * @param array $routes
     */
    public function __construct(array $routes)
    {
        $this->provisionRoutes($routes);
        $this->makeRequestContext();

        [$this->controller, $this->method] = $this->urlMatching();
    }

    /**
     * @param array $routes
     */
    protected function provisionRoutes(array $routes): void
    {
        $this->routes = new RouteCollection();

        foreach ($routes as $key => $route) {
            $this->routes->add($key, $route);
        }
    }

    protected function makeRequestContext(): void
    {
        $this->request = Request::createFromGlobals();
        $this->context = new RequestContext();
        $this->context->fromRequest($this->request);

        if (isset($_POST['_method']) && in_array(strtoupper($_POST['_method']), Route::HTTP_METHODS)) {
            $this->context->setMethod($_POST['_method']);
        }
    }

    /**
     * @return array
     */
    protected function urlMatching(): array
    {
        $matcher = new UrlMatcher($this->routes, $this->context);
        $this->params = $matcher->match($this->request->getPathInfo());

        return [$this->params['_controller'], $this->params['_method']];
    }

    public function getInstance(): void
    {
        $this->cleanParams();
        call_user_func_array([new $this->controller(), $this->method], $this->params);
    }

    protected function cleanParams(): void
    {
        foreach ($this->params as $key => $param) {
            if (str_starts_with($key, '_')) {
                unset($this->params[$key]);
            }
        }
    }
}