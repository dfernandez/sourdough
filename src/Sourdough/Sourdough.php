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

class Sourdough extends Application
{
    use TwigTrait;
    use UrlGeneratorTrait;

    protected $config = [];

    public function __construct()
    {
        $this->config = require __DIR__.'/../../config/local.php';

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
    }
}
