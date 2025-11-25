<?php

namespace AlmosabbirRakib\LaravelDebugger\DataCollectors;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;

class QueryCollector extends DataCollector
{
    protected string $name = 'queries';
    protected array $queries = [];
    protected int $maxQueries;

    public function __construct(?int $maxQueries = null)
    {
        $this->maxQueries = $maxQueries ?? config('debugger.queries.max_queries', 100);
        $this->listen();
    }

    protected function listen(): void
    {
        DB::listen(function (QueryExecuted $query) {
            if (count($this->queries) >= $this->maxQueries) {
                return;
            }

            $this->queries[] = [
                'query' => $query->sql,
                'bindings' => $query->bindings,
                'time' => $query->time,
                'connection' => $query->connectionName,
            ];
        });
    }

    public function collect(): void
    {
        $totalTime = array_sum(array_column($this->queries, 'time'));

        $this->data = [
            'queries' => array_map(function ($query) {
                return [
                    'query' => $this->interpolateQuery($query['query'], $query['bindings']),
                    'raw_query' => $query['query'],
                    'bindings' => $query['bindings'],
                    'time' => round($query['time'], 2),
                    'connection' => $query['connection'],
                ];
            }, $this->queries),
            'total_queries' => count($this->queries),
            'total_time' => round($totalTime, 2),
        ];
    }

    protected function interpolateQuery(string $query, array $bindings): string
    {
        if (empty($bindings)) {
            return $query;
        }

        $query = str_replace(['%', '?'], ['%%', '%s'], $query);
        
        $bindings = array_map(function ($binding) {
            if (is_null($binding)) {
                return 'NULL';
            }
            if (is_bool($binding)) {
                return $binding ? 'TRUE' : 'FALSE';
            }
            if (is_numeric($binding)) {
                return $binding;
            }
            return "'" . addslashes($binding) . "'";
        }, $bindings);

        return vsprintf($query, $bindings);
    }
}
