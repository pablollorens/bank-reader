<?php

namespace BankReader\Data;

use BankReader\Core\Kernel;
use BankReader\Model\Transaction;
use Symfony\Component\Finder\Finder;
use PHPExcel_IOFactory;
use PHPExcel;
use BankReader\Core\Container;

class Loader
{
    public static function fromExcelFiles(Container $container)
    {
        $parameters = $container->getParameters();

        /** @var Kernel $kernel */
        $kernel = $container->getKernel();

        $initialFolder = $kernel->getRootDir() . $parameters['data_folder'];

        $transactionDateColumn = $parameters['excel']['transaction_date_column'];
        $amountColumn = $parameters['excel']['amount_column'];
        $descriptionColumn = $parameters['excel']['description_column'];

        // Read categories
        $categories = $parameters['categories'];
        $container->addService('categories', $categories);

        $transactions = array();

        $finder = new Finder;

        $finder->in($initialFolder)->name("*.xls")->sortByName();;

        foreach($finder as $file) {
            /** @var PHPExcel $objPHPExcel */
            $objPHPExcel = PHPExcel_IOFactory::load($file->getRealPath());

            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

            foreach ($sheetData as $key => $row) {

                if ($key === 1) continue;

                $transaction = new Transaction();

                $transaction->setDate(\DateTime::createFromFormat('Ymd', $row[$transactionDateColumn]));

                $amount = floatval($row[$amountColumn]);
                if ($amount < 0) {
                    $amount *= -1;
                }
                $transaction->setAmount($amount);

                $transaction->setDescription($row[$descriptionColumn]);

                // Retrieve keywords
                $explode = explode(' ', $row[$descriptionColumn]);
                $array_map = array_map('strtolower', $explode);

                $transaction->setKeywords($array_map);

                $transactions[] = $transaction;
            }
        }

        $transactions = self::loadCategories($transactions, $categories);

        return $transactions;
    }

    protected static function loadCategories($transactions, $categories)
    {
        /** @var Transaction $transaction */
        foreach ($transactions as $transaction) {

            // Detect from which category is each transaction
            foreach ($categories as $category) {
                $categoryName = key($category);
                $keywords = array_shift($category);

                $intersect = array_intersect($transaction->getKeywords(), $keywords);

                if (0 < count($intersect)) {
                    $transaction->addCategory($categoryName);
                }
            }
        }

        return $transactions;
    }
}
