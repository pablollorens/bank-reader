<?php

namespace BankReader\Controller;

use BankReader\Core\Container;
use BankReader\Data\Adaptor;

class MainController
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function indexAction()
    {
        /** @var \Twig_Template $template */
        $template = $this->container->get('twig')->loadTemplate("index.html.twig");

        $categories = $this->container->get('categories');

        $returnedArray = Adaptor::prepareLineChartData($this->container->get('transactions'), $categories);

        return $template->render(array(
            'data' => $returnedArray[0],
            'rawData' => $returnedArray[1],
            'trash' => $returnedArray[2],
            'categories' => $categories,
        ));
    }

    public function exploreAction($date)
    {
        /** @var \Twig_Template $template */
        $template = $this->container->get('twig')->loadTemplate("explore.html.twig");

        $categories = $this->container->get('categories');

        $returnedArray = Adaptor::prepareLineChartData($this->container->get('transactions'), $categories);

        return $template->render(array(
            'rawData' => $returnedArray[1][$date],
            'categories' => $categories
        ));
    }
}
