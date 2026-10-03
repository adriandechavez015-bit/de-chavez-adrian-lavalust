<?php

class Migration
{
    public static $command = 'migration';

    public static $description = 'Run database migrations';

    public static $arguments = [
        '[action]' => 'Action: run, create-migration, rollback, rollback-all, refresh, status',
        '[name]'   => 'Migration class name for create-migration',
    ];

    protected static $route_map = [
        'run'              => 'migrate',
        'create-migration' => 'create-migration',
        'rollback'         => 'rollback',
        'rollback-all'     => 'rollback-all',
        'refresh'          => 'refresh',
        'status'           => 'status',
    ];

    public function handle($action = null, array $flags = [], $name = null)
    {
        $action = $action ?? 'run';

        if (!isset(static::$route_map[$action])) {
            echo danger("Unknown migration action: \"{$action}\"");
            echo "Available actions: "
                . implode(', ', array_keys(static::$route_map))
                . PHP_EOL;
            exit(1);
        }

        if ($action === 'create-migration') {
            if (!$name) {
                echo danger("Migration name is required.");
                echo "Example: php lava migration create-migration create_users_table"
                    . PHP_EOL;
                exit(1);
            }

            $route = 'create-migration/' . $name;
        } else {
            $route = static::$route_map[$action];
        }

        $index = PUBLIC_DIR . 'index.php';

        if (!file_exists($index)) {
            echo danger("index.php not found at: {$index}");
            exit(1);
        }

        // Sets REQUEST_METHOD environment variable for the PHP CLI execution
        $envPrefix = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') 
            ? 'cmd /C "set REQUEST_METHOD=GET && ' 
            : 'REQUEST_METHOD=GET ';

        $envSuffix = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? '"' : '';

        $command = sprintf(
            '%sphp %s %s%s',
            $envPrefix,
            escapeshellarg($index),
            escapeshellarg($route),
            $envSuffix
        );

        passthru($command);
    }
}