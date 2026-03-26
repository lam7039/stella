<?php

use Stella\Support\Str;
use Stella\Support\Env;

if (! function_exists('str')) {
    function str(string $value = ''): Str {
        return Str::of($value);
    }
}

if (! function_exists('env')) {
    $env = new Env;
    function env(string $key, mixed $default = null) : string|null {
        global $env;
        return $env->get($key) ?? $default;
    }
}

if (! function_exists('config')) {
    function config(string $key, mixed $default = null) {
        global $config;

        $keys = explode('.', $key);
        $value = $config;

        foreach ($keys as $k) {
            if (! isset($value[$k])) {
                return $default;
            }

            $value = $value[$k];
        }

        return $value;
    }
}

if (! function_exists('output')) {
    function output(mixed $param) : void {
        if (! $param instanceof \Throwable) {
            //TODO: use unified style with log but without table
            echo '<pre>' . var_export($param, true) . '</pre>';
            return;
        }

        //TODO: see if this can be unified with the file logger
        echo file_get_contents('./public/templates/debug.html');

        $defaults = [
            'message' => 'n/a',
            'file' => 'n/a',
            'line' => 'n/a'
        ];

        [$message, $file, $line] = array_merge($defaults, [$param->getMessage(), $param->getFile(), $param->getLine()]);

        $timestamp = date('Y-m-d H:i:s', time());
        $route = explode('/', $file);
        $file = array_pop($route);
        $error_type = get_error_type($param->getCode());

        //TODO: collapsible trace
        $table = '<tr class="' . $error_type->value . '">
            <td>' . $timestamp . '</td>
            <td>' . $message . '</td>
            <td>' . $file . '</td>
            <td>' . $line . '</td>
        </tr>';

        foreach ($param->getTrace() as $trace) {
            ['message' => $message, 'file' => $file, 'line' => $line, 'class' => $class, 'type' => $type, 'function' => $function] = array_merge($defaults, $trace);

            if ($message === 'n/a' && $class && $function) {
                $message = $class . $type . $function;
            }

            //TODO: explode at project name (set limit)
            $route = explode('/', $file);
            $file = array_pop($route);

            $table .= '<tr class="' . $error_type->value . '">
                <td>' . $timestamp . '</td>
                <td>' . $message . '</td>
                <td>' . $file . '</td>
                <td>' . $line . '</td>
            </tr>';
        }

        echo $table . '</table>';
    }
}

if (! function_exists('dump')) {
    function dump(mixed ...$params) : void {
        array_map(fn(mixed $param) => output(is_string($param) ? htmlspecialchars($param) : $param), $params);
    }
}

if (! function_exists('dd')) {
    function dd(mixed ...$params) : never {
        dump(...$params);
        exit;
    }
}
