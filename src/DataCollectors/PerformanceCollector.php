<?php

namespace AlmosabbirRakib\LaravelDebugger\DataCollectors;

class PerformanceCollector extends DataCollector
{
    protected string $name = 'performance';
    protected float $startTime;
    protected int $startMemory;

    public function __construct()
    {
        $this->startTime = defined('LARAVEL_START') ? LARAVEL_START : microtime(true);
        $this->startMemory = memory_get_usage();
    }

    public function collect(): void
    {
        $endTime = microtime(true);
        $endMemory = memory_get_usage();

        $this->data = [
            'execution_time' => round(($endTime - $this->startTime) * 1000, 2), // ms
            'memory_peak' => $this->formatBytes(memory_get_peak_usage(true)),
            'memory_peak_bytes' => memory_get_peak_usage(true),
            'memory_current' => $this->formatBytes($endMemory),
            'memory_current_bytes' => $endMemory,
            'memory_used' => $this->formatBytes($endMemory - $this->startMemory),
            'memory_used_bytes' => $endMemory - $this->startMemory,
            'included_files' => count(get_included_files()),
        ];

        // Add server load if available
        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
            $this->data['server_load'] = [
                '1min' => round($load[0], 2),
                '5min' => round($load[1], 2),
                '15min' => round($load[2], 2),
            ];
        }
    }
}
