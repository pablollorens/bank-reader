<?php

namespace BankReader\Data;

use BankReader\Model\Transaction;

class Adaptor
{
    public static function prepareLineChartData(array $transactions, array $categories)
    {
        $data = array();

        $trash = array();

        /** @var Transaction $transaction */
        foreach ($transactions as $transaction) {

            $transactionDate = $transaction->getDate()->format('Y-m');

            if (!isset($data[$transactionDate])) {
                $data[$transactionDate] = self::createRow($categories);
            }

            if (count($transaction->getCategories()) > 0) {
                foreach ($transaction->getCategories() as $categoryName) {
                    $data[$transactionDate][$categoryName] += $transaction->getAmount();
                }
            } else {
                $trash[] = $transaction;
            }
        }

        return array($data, $trash);
    }

    public static function createRow($categories)
    {
        $row = array();

        foreach ($categories as $name => $keywords)
        {
            $row[$name] = 0.0;
        }

        return $row;
    }
}
