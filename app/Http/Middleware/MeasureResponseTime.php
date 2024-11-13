<?php

namespace App\Http\Middleware;

use App\Services\AnalyzeService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MeasureResponseTime
{
    protected $analyzeService;

    public function __construct(AnalyzeService $analyzeService)
    {
        $this->analyzeService = $analyzeService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        $response = $next($request);
        $endTime = microtime(true);

        $duration = number_format(($endTime - $startTime) * 1000, 2) . ' ms';
        if (config('services.kafka.enable')) {
            defer(fn() => $this->analyzeService->produce($request, $duration))->always();
        }

        return $response;
    }
}
