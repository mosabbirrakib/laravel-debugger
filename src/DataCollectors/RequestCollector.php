<?php

namespace AlmosabbirRakib\LaravelDebugger\DataCollectors;

use Illuminate\Http\Request;

class RequestCollector extends DataCollector
{
    protected string $name = 'request';

    public function __construct(protected Request $request)
    {
    }

    public function collect(): void
    {
        $this->data = [
            'method' => $this->request->method(),
            'uri' => $this->request->fullUrl(),
            'path' => $this->request->path(),
            'ip' => $this->request->ip(),
            'ajax' => $this->request->ajax(),
            'secure' => $this->request->secure(),
            'headers' => $this->collectHeaders(),
            'input' => $this->collectInput(),
            'session' => $this->collectSession(),
            'cookies' => $this->collectCookies(),
        ];
    }

    protected function collectHeaders(): array
    {
        $headers = [];
        foreach ($this->request->headers->all() as $key => $value) {
            $headers[$key] = is_array($value) ? implode(', ', $value) : $value;
        }
        return $headers;
    }

    protected function collectInput(): array
    {
        return [
            'get' => $this->request->query->all(),
            'post' => $this->request->request->all(),
            'files' => array_map(fn($file) => [
                'name' => $file->getClientOriginalName(),
                'size' => $this->formatBytes($file->getSize()),
            ], $this->request->files->all()),
        ];
    }

    protected function collectSession(): array
    {
        if (!$this->request->hasSession()) {
            return [];
        }

        $session = $this->request->session()->all();
        
        // Remove sensitive data
        $excluded = ['_token', 'password', 'password_confirmation'];
        foreach ($excluded as $key) {
            unset($session[$key]);
        }

        return $session;
    }

    protected function collectCookies(): array
    {
        return $this->request->cookies->all();
    }
}
