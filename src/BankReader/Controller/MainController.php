<?php

namespace BankReader\Controller;

use BankReader\Core\Container;
use BankReader\Model\Transaction;

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

        $total = 0;
        $totals = array();

        /** @var Transaction $transaction */
        foreach ($this->container->getTransactions() as $transaction) {

            // Detect from which category is each transaction
            foreach ($this->container->getCategories() as $category) {
                $categoryName = key($category);
                $keywords = array_shift($category);

                $intersect = array_intersect($transaction->getKeywords(), $keywords);

                if (0 < count($intersect)) {
                    $transaction->addCategory($categoryName);
                }
            }

            $date = $transaction->getDate();

            foreach ($transaction->getCategories() as $category) {
                $year = $date->format('Y');
                $month = $date->format('F');

                if (isset($totals[$year][$month][$category])) {
                    $totals[$year][$month][$category] += $transaction->getAmount();
                } else {
                    $totals[$year][$month][$category] = $transaction->getAmount();
                }

                if (isset($totals[$year][$month]['total'])) {
                    $totals[$year][$month]['total'] += $transaction->getAmount();
                } else {
                    $totals[$year][$month]['total'] = $transaction->getAmount();
                }

                $total += $transaction->getAmount();
            }
        }

        return $template->render(array(
            'totals' => $totals,
            'total' => $total
        ));
    }
}
