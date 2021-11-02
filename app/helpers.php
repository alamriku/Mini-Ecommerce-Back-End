<?php
use App\Services\Activity\ActivityLogger;

if (! function_exists('activity')) {
    function activity(string $logName = null): ActivityLogger
    {
        $defaultLogName = "default";
        return app(ActivityLogger::class)
            ->withname($logName ?? $defaultLogName);
    }
}
