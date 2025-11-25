<?php

namespace AlmosabbirRakib\LaravelDebugger\Middleware;

use AlmosabbirRakib\LaravelDebugger\DataCollectors\RequestCollector;
use AlmosabbirRakib\LaravelDebugger\DataCollectors\RouteCollector;
use AlmosabbirRakib\LaravelDebugger\DataCollectors\QueryCollector;
use AlmosabbirRakib\LaravelDebugger\DataCollectors\ViewCollector;
use AlmosabbirRakib\LaravelDebugger\DataCollectors\LogCollector;
use AlmosabbirRakib\LaravelDebugger\DataCollectors\PerformanceCollector;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DebugbarMiddleware
{
    protected array $collectors = [];

    public function handle(Request $request, Closure $next)
    {
        // Check if debugger is enabled
        if (!$this->isEnabled()) {
            return $next($request);
        }

        // Check if route should be excluded
        if ($this->shouldExclude($request)) {
            return $next($request);
        }

        // Initialize collectors that need early setup
        $this->initializeCollectors($request);

        $response = $next($request);

        // Inject debugger only for HTML responses
        if ($this->canInject($response)) {
            $this->injectDebugger($response);
        }

        return $response;
    }

    protected function isEnabled(): bool
    {
        if (!config('debugger.enabled', false)) {
            return false;
        }

        $allowedEnvironments = config('debugger.allowed_environments', []);
        
        if (empty($allowedEnvironments)) {
            return true;
        }

        return in_array(app()->environment(), $allowedEnvironments);
    }

    protected function shouldExclude(Request $request): bool
    {
        $except = config('debugger.except', []);
        
        foreach ($except as $pattern) {
            if ($request->is($pattern)) {
                return true;
            }
        }

        return false;
    }

    protected function initializeCollectors(Request $request): void
    {
        $config = config('debugger.collectors', []);

        if ($config['queries'] ?? false) {
            $this->collectors['queries'] = new QueryCollector();
        }

        if ($config['views'] ?? false) {
            $this->collectors['views'] = new ViewCollector();
        }

        if ($config['logs'] ?? false) {
            $this->collectors['logs'] = new LogCollector();
        }

        if ($config['performance'] ?? false) {
            $this->collectors['performance'] = new PerformanceCollector();
        }

        if ($config['request'] ?? false) {
            $this->collectors['request'] = new RequestCollector($request);
        }

        if ($config['route'] ?? false) {
            $this->collectors['route'] = new RouteCollector($request);
        }
    }

    protected function canInject($response): bool
    {
        if (!$response instanceof Response) {
            return false;
        }

        if ($response instanceof StreamedResponse || $response instanceof BinaryFileResponse) {
            return false;
        }

        $contentType = $response->headers->get('Content-Type', '');
        
        return str_contains($contentType, 'html') || empty($contentType);
    }

    protected function injectDebugger(Response $response): void
    {
        $content = $response->getContent();

        if (empty($content) || !str_contains($content, '</body>')) {
            return;
        }

        // Collect all data
        $debugData = $this->collectData();

        // Render debugger HTML
        $debuggerHtml = view('debugger::debugger', [
            'data' => $debugData,
        ])->render();

        // Inject before closing body tag
        $content = str_replace('</body>', $debuggerHtml . '</body>', $content);
        $response->setContent($content);
    }

    protected function collectData(): array
    {
        $data = [];

        foreach ($this->collectors as $name => $collector) {
            $collector->collect();
            $data[$name] = $collector->getData();
        }

        return $data;
    }
}
