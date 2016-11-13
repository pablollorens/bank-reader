<?php

namespace BankReader\Data;

use BankReader\Model\Transaction;

class Adaptor
{
    public static function prepareLineChartData(array $transactions, array $categories)
    {
        foreach ($categories as $key => $category) {
            $categories[$key] = key($category);
        }

        $data = array();

        $data[] = array_merge(array('Date'), $categories);

        /** @var Transaction $transaction */
        foreach ($transactions as $transaction) {

            $transactionDate = $transaction->getDate()->format('d-m-Y');

            if (!isset($data[$transactionDate])) {
                $data[$transactionDate] = self::createRow($categories);
            }

            foreach ($transaction->getCategories() as $category) {
                $data[$transactionDate][$category] += $transaction->getAmount();
            }
        }

        return $data;
    }

    public static function createRow($categories)
    {
        $row = array();

        foreach ($categories as $category)
        {
            $row[$category] = 0.0;
        }

        return $row;
    }
}
