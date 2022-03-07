<?php

namespace Frontify\ColorApi\Utils;

class ContainerRegistry
{
    private static ?ContainerRegistry $instance = null;

    private array $services;

    private function __construct()
    {
        $this->services = [];
    }

    public static function getInstance(): ?ContainerRegistry
    {
        if (self::$instance == null) {
            self::$instance = new ContainerRegistry();
        }

        return self::$instance;
    }

    public function get(string $key)
    {
        return $this->services[$key] ?? null;
    }

    public function set(string $key, $service): void
    {
        $this->services[$key] = $service;
    }
}
