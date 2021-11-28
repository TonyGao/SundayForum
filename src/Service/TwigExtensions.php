<?php

namespace App\Service;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TwigExtensions extends AbstractExtension
{
    protected $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('get_parameter', [$this, 'getParameter'])
        ];
    }

    public function getParameter($parameter)
    {
        return $this->params->get($parameter);
    }

    public function getName()
    {
        return 'TwigExtensions';
    }
}