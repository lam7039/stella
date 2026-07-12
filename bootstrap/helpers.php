<?php

use Stella\Core\App;
use Stella\Core\Config\DotEnv;
use Stella\Core\Config\Config;
use Stella\Core\Http\Request\Request;
use Stella\Core\Logging\Logger;
use Stella\Core\Logging\ErrorType;
use Stella\Core\Http\Session;
use Stella\Core\Storage\StorageManager;
use Stella\Core\Storage\Contracts\StorageInterface;
use Stella\Support\Str;
use Stella\Support\Collection;
use Stella\Support\File;

if (! function_exists('str')) {
    function str(string $value = ''): Str
    {
        return Str::of($value);
    }
}

if (! function_exists('collect')) {
    function collect(array $items = []): Collection
    {
        return new Collection($items);
    }
}

if (! function_exists('base_path')) {
    function base_path(string $path = ''): string
    {
        $base = dirname(__DIR__);
        $path = ltrim($path, '/\\');

        return $path === ''
            ? $base
            : $base . '/' . $path;
    }
}

if (! function_exists('config_path')) {
    function config_path(string $path = ''): string
    {
        return base_path('config/' . ltrim($path, '/\\'));
    }
}

if (! function_exists('public_path')) {
    function public_path(string $path = ''): string
    {
        return base_path('public/' . ltrim($path, '/\\'));
    }
}

if (! function_exists('storage_path')) {
    function storage_path(string $path = ''): string
    {
        return base_path('storage/' . ltrim($path, '/\\'));
    }
}

if (! function_exists('src_path')) {
    function src_path(string $path = ''): string
    {
        return base_path('src/' . ltrim($path, '/\\'));
    }
}

if (! function_exists('routes_path')) {
    function routes_path(string $path = ''): string
    {
        return base_path('routes/' . ltrim($path, '/\\'));
    }
}

if (! function_exists('env_path')) {
    function env_path(): string
    {
        return base_path('.env');
    }
}

if (! function_exists('app')) {
    function app(): App
    {
        return App::instance();
    }
}

if (! function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        return app()->get(DotEnv::class)->get($key, $default);
    }
}

if (! function_exists('config')) {
    function config(string $key, mixed $default = null): mixed
    {
        return app()->get(Config::class)->get($key, $default);
    }
}

if (! function_exists('session')) {
    function session(): Session
    {
        return app()->get(Session::class);
    }
}

if (! function_exists('session_get')) {
    function session_get(string $key, mixed $default = null): mixed
    {
        return session()->get($key, $default);
    }
}

if (! function_exists('session_set')) {
    function session_set(string $key, mixed $value): void
    {
        session()->set($key, $value);
    }
}

if (! function_exists('session_has')) {
    function session_has(string $key): bool
    {
        return session()->has($key);
    }
}

if (! function_exists('session_forget')) {
    function session_forget(string $key): void
    {
        session()->remove($key);
    }
}

if (! function_exists('session_flash')) {
    function session_flash(string $key, mixed $value): void
    {
        session()->flash($key, $value);
    }
}

if (! function_exists('session_flash_get')) {
    function session_flash_get(string $key, mixed $default = null): mixed
    {
        return session()->getFlash($key, $default);
    }
}

if (! function_exists('logger')) {
    function logger(): Logger
    {
        return app()->get(Logger::class);
    }
}

if (! function_exists('request')) {
    function request(): Request
    {
        return app()->get(Request::class);
    }
}

//TODO: create the Response class and use it here
// if (! function_exists('response')) {
//     function response(): Response
//     {
//         return app()->get(Response::class)
//     }
// }

//TODO: create the HttpException class and use it here
// if (! function_exists('abort')) {
//     function abort(int $code, string $message = ''): void
//     {
//         throw new HttpException($code, $message);
//     }
// }

if (! function_exists('file_object')) {
    function file_object(string $path): File
    {
        return File::of($path);
    }
}

if (! function_exists('storage')) {
    function storage(?string $disk = null): StorageManager|StorageInterface
    {
        $manager = app()->get(StorageManager::class);

        return $disk
            ? $manager->disk($disk)
            : $manager;
    }
}

//TODO: refactor the output, dump and dd methods
if (! function_exists('output')) {
    function output(mixed $param): void
    {
        if (! $param instanceof \Throwable) {
            //TODO: use unified style with log but without table
            echo '<pre>' . var_export($param, true) . '</pre>';
            return;
        }

        //TODO: see if this can be unified with the file logger
        echo file_get_contents(base_path('public/templates/debug.html'));

        $defaults = [
            'message' => 'n/a',
            'file' => 'n/a',
            'line' => 'n/a'
        ];

        [$message, $file, $line] = array_merge($defaults, [$param->getMessage(), $param->getFile(), $param->getLine()]);

        $timestamp = date('Y-m-d H:i:s', time());
        $route = explode('/', $file);
        $file = array_pop($route);
        $error_type = ErrorType::fromCode($param->getCode());

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
    function dump(mixed ...$params): void
    {
        array_map(fn(mixed $param) => output(is_string($param) ? htmlspecialchars($param) : $param), $params);
    }
}

if (! function_exists('dd')) {
    function dd(mixed ...$params): never
    {
        dump(...$params);
        exit;
    }
}
