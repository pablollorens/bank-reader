<?php

namespace BankReader\File;

use BankReader\Core\Kernel;
use BankReader\Model\Transaction;
use Symfony\Component\Finder\Finder;
use PHPExcel_IOFactory;
use PHPExcel;

class Parser
{
    protected $initialFolder = '';

    protected $transactionDateColumn = 'C';
    protected $amountColumn = 'G';
    protected $descriptionColumn = 'H';

    public function __construct($container)
    {
        $parameters = $container->getParameters();

        /** @var Kernel $kernel */
        $kernel = $container->getKernel();

        $this->initialFolder = $kernel->getRootDir() . $parameters['data_folder'];

        $this->transactionDateColumn = $parameters['excel']['transaction_date_column'];
        $this->amountColumn = $parameters['excel']['amount_column'];
        $this->descriptionColumn = $parameters['excel']['description_column'];
    }

    public function parse()
    {
        $transactions = array();

        $finder = new Finder;

        $finder->in($this->initialFolder)->name("*.xls")->sortByName();;

        foreach($finder as $file) {
            /** @var PHPExcel $objPHPExcel */
            $objPHPExcel = PHPExcel_IOFactory::load($file->getRealPath());

            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

            foreach($sheetData as $row) {
                $transaction = new Transaction();

                $transaction->setDate(\DateTime::createFromFormat('Ymd', $row[$this->transactionDateColumn]));

                $amount = floatval($row[$this->amountColumn]);
                if ($amount < 0) {
                    $amount *= -1;
                }
                $transaction->setAmount($amount);

                $transaction->setDescription($row[$this->descriptionColumn]);

                // Retrieve keywords
                $explode = explode(' ', $row[$this->descriptionColumn]);
                $array_map = array_map('strtolower', $explode);

                $transaction->setKeywords($array_map);

                $transactions[] = $transaction;
            }
        }

        return $transactions;
    }
}
