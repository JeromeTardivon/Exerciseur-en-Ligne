<?php

namespace config;

class DotEnv
{
    public function load($path): void
    {
        $lines = file($path . '/.env');
        foreach ($lines as $line) {
            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            putenv(sprintf('%s=%s', $key, $value));
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}