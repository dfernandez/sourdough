<?php

namespace Sourdough;

use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;
use Silex\Application\TwigTrait;
use Silex\Application\UrlGeneratorTrait;
use Silex\Application;
use Twig_Extensions_Extension_Intl;

class Sourdough extends Application
{
    use TwigTrait;
    use UrlGeneratorTrait;

    protected $config = [];

    public function __construct($config)
    {
        $this->config = $config;

        parent::__construct(['debug' => $this->config['debug']]);

        # Services
        $this->register(new MonologServiceProvider(), $this->config['monolog']);
        $this->register(new TwigServiceProvider(), $this->config['twig']);

        # Web profiling
        if ($this->config['debug'] === true) {
            $this->register(new HttpFragmentServiceProvider());
            $this->register(new ServiceControllerServiceProvider());
            $this->register(new UrlGeneratorServiceProvider());
            $this->register(new WebProfilerServiceProvider(), $this->config['profiler']);
        }

        $this->registerServices();
    }

    private function registerServices()
    {
        $app = $this;

        // Register Twig Intl extension
        $app['twig']->addExtension(new Twig_Extensions_Extension_Intl());
    }
}
