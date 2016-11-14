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
        $template = $this->container->getTwig()->loadTemplate("index.html.twig");

        $categories = $this->container->getCategories();

        $data = Adaptor::prepareLineChartData($this->container->getTransactions(), $categories);

        return $template->render(array(
            'data' => $data,
            'categories' => $categories,
        ));
    }
}
