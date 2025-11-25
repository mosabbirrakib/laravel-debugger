<?php

namespace AlmosabbirRakib\LaravelDebugger\DataCollectors;

abstract class DataCollector
{
    /**
     * Collected data storage
     */
    protected array $data = [];

    /**
     * Collector name
     */
    protected string $name;

    /**
     * Collect debug data
     */
    abstract public function collect(): void;

    /**
     * Get collected data
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Get collector name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Format bytes to human readable format
     */
    protected function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Format duration to milliseconds
     */
    protected function formatDuration(float $seconds): string
    {
        return round($seconds * 1000, 2) . ' ms';
    }
}
