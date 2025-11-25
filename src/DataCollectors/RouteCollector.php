<?php

namespace AlmosabbirRakib\LaravelDebugger\DataCollectors;

use Illuminate\Routing\Route;
use Illuminate\Http\Request;

class RouteCollector extends DataCollector
{
    protected string $name = 'route';

    public function __construct(protected Request $request)
    {
    }

    public function collect(): void
    {
        $route = $this->request->route();

        if (!$route instanceof Route) {
            $this->data = ['error' => 'No route matched'];
            return;
        }

        $this->data = [
            'name' => $route->getName(),
            'uri' => $route->uri(),
            'methods' => $route->methods(),
            'action' => $this->getAction($route),
            'controller' => $this->getController($route),
            'middleware' => $this->getMiddleware($route),
            'parameters' => $route->parameters(),
            'wheres' => $route->wheres,
        ];
    }

    protected function getAction(Route $route): string
    {
        $action = $route->getAction();
        
        if (isset($action['controller'])) {
            return $action['controller'];
        }

        return is_callable($action['uses']) ? 'Closure' : (string) $action['uses'];
    }

    protected function getController(Route $route): ?string
    {
        $controller = $route->getController();
        
        return $controller ? get_class($controller) : null;
    }

    protected function getMiddleware(Route $route): array
    {
        return array_values($route->gatherMiddleware());
    }
}
