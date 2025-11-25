<?php

namespace AlmosabbirRakib\LaravelDebugger\DataCollectors;

use Illuminate\Support\Facades\Event;
use Illuminate\View\View;

class ViewCollector extends DataCollector
{
    protected string $name = 'views';
    protected array $views = [];

    public function __construct()
    {
        $this->listen();
    }

    protected function listen(): void
    {
        Event::listen('composing:*', function ($view, $data = null) {
            // Handle different event formats
            if ($view instanceof View) {
                $this->addView($view);
            } elseif (is_string($view) && $data instanceof View) {
                $this->addView($data);
            }
        });
    }

    protected function addView(View $view): void
    {
        $this->views[] = [
            'name' => $view->name(),
            'path' => $view->getPath(),
            'data' => $this->sanitizeData($view->getData()),
        ];
    }

    public function collect(): void
    {
        $this->data = [
            'views' => $this->views,
            'total_views' => count($this->views),
        ];
    }

    protected function sanitizeData(array $data): array
    {
        $sanitized = [];
        
        foreach ($data as $key => $value) {
            // Skip Laravel internal variables
            if (in_array($key, ['__env', 'app', 'errors', 'obLevel'])) {
                continue;
            }

            // Limit data size for display
            if (is_object($value)) {
                $sanitized[$key] = get_class($value);
            } elseif (is_array($value)) {
                $sanitized[$key] = '[Array: ' . count($value) . ' items]';
            } else {
                $sanitized[$key] = $value;
            }
        }

        return $sanitized;
    }
}
