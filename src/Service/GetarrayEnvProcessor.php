<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\EnvVarProcessorInterface;

class GetarrayEnvProcessor implements EnvVarProcessorInterface
{
    public function getEnv(string $prefix, string $name, \Closure $getEnv)
    {
        $env = $getEnv($name);

        return explode(',', $env);;
    }

    public static function getProvidedTypes()
    {
        return [
            'getarray' => 'string',
        ];
    }
}
