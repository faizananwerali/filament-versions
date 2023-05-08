<?php

namespace FilamentVersions;

use Closure;
use Composer\InstalledVersions;
use Filament\Context;
use Filament\Contracts\Plugin;
use Filament\Support\Assets\Css;
use Filament\Support\Concerns\EvaluatesClosures;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\View\View;
use Livewire\Livewire;

class VersionsPlugin implements Plugin
{
    use EvaluatesClosures;

    protected array $items = [];

    protected bool $shouldRegisterNavigationView = true;

    public function getId(): string
    {
        return 'filament-versions';
    }

    public function register(Context $context): void
    {
        FilamentAsset::register([
            Css::make('filament-versions', __DIR__ . '/../resources/dist/filament-versions.css'),
        ], 'filament-versions');
    }

    public function boot(Context $context): void
    {
        Livewire::component('versions-widget', VersionsWidget::class);

        if ($this->hasNavigationView()) {
            $context->renderHook(
                name: 'sidebar.end',
                callback: fn(): View => view('filament-versions::filament-versions', ['versions' => $this->getItems()])
            );
        }
    }

    public function addItem(string $name, string|Closure $version = ''): static
    {
        if ($version instanceof Closure) {
            $version = $version();
        }

        $this->items[str()->slug($name)] = [
            'name' => $name,
            'version' => $version,
        ];

        return $this;
    }

    public function getItems(): array
    {
        $this->items = array_merge([
            'laravel' => [
                'name' => 'Laravel',
                'version' => InstalledVersions::getPrettyVersion('laravel/framework'),
            ],
            'filament' => [
                'name' => 'Filament',
                'version' => InstalledVersions::getPrettyVersion('filament/filament'),
            ],
            'php' => [
                'name' => 'PHP',
                'version' => PHP_VERSION,
            ],
        ], $this->items);

        return $this->evaluate($this->items);
    }

    public function hasNavigationView(): bool
    {
        return $this->evaluate($this->shouldRegisterNavigationView);
    }

    public function registerNavigationView(bool|Closure $condition): static
    {
        $this->shouldRegisterNavigationView = $condition;

        return $this;
    }

    public function shouldRegisterNavigationView(): bool
    {
        return $this->shouldRegisterNavigationView;
    }
}