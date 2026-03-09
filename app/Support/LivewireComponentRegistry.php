<?php

namespace App\Support;

use Livewire\LivewireManager;

/**
 * Backwards-compat shim for older packages (like laravel-ignition)
 * that still expect Livewire\Mechanisms\ComponentRegistry.
 */
class LivewireComponentRegistry
{
    public function getClass(string $alias): ?string
    {
        try {
            /** @var LivewireManager $manager */
            $manager = app(LivewireManager::class);

            return $manager->getClass($alias);
        } catch (\Throwable $e) {
            return null;
        }
    }
}

