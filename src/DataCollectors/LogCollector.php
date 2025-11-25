<?php

namespace AlmosabbirRakib\LaravelDebugger\DataCollectors;

use Illuminate\Log\Events\MessageLogged;
use Illuminate\Support\Facades\Event;

class LogCollector extends DataCollector
{
    protected string $name = 'logs';
    protected array $logs = [];
    protected int $maxLogs;

    public function __construct(?int $maxLogs = null)
    {
        $this->maxLogs = $maxLogs ?? config('debugger.logs.max_logs', 50);
        $this->listen();
    }

    protected function listen(): void
    {
        Event::listen(MessageLogged::class, function (MessageLogged $log) {
            if (count($this->logs) >= $this->maxLogs) {
                return;
            }

            $this->logs[] = [
                'level' => $log->level,
                'message' => $log->message,
                'context' => $log->context,
                'time' => microtime(true),
            ];
        });
    }

    public function collect(): void
    {
        $this->data = [
            'logs' => array_map(function ($log) {
                return [
                    'level' => $log['level'],
                    'message' => $log['message'],
                    'context' => $log['context'],
                    'timestamp' => date('H:i:s', (int) $log['time']),
                ];
            }, $this->logs),
            'total_logs' => count($this->logs),
            'by_level' => $this->groupByLevel(),
        ];
    }

    protected function groupByLevel(): array
    {
        $grouped = [];
        
        foreach ($this->logs as $log) {
            $level = $log['level'];
            if (!isset($grouped[$level])) {
                $grouped[$level] = 0;
            }
            $grouped[$level]++;
        }

        return $grouped;
    }
}
