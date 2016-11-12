<?php

namespace BankReader\File;

use BankReader\Model\Transaction;
use Symfony\Component\Finder\Finder;
use PHPExcel_IOFactory;
use PHPExcel;

class Parser
{
    protected $initialFolder = '';

    const TRANSACTION_DATE_COLUMN = 'C';
    const AMOUNT_COLUMN = 'G';
    const DESCRIPTION_COLUMN = 'H';

    public function __construct($initialFolder = '')
    {
        $this->initialFolder = $initialFolder;
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

                $transaction->setDate(\DateTime::createFromFormat('Ymd', $row[self::TRANSACTION_DATE_COLUMN]));

                $transaction->setAmount(floatval($row[self::AMOUNT_COLUMN]));

                $transaction->setDescription($row[self::DESCRIPTION_COLUMN]);

                // Retrieve keywords
                $explode = explode(' ', $row[self::DESCRIPTION_COLUMN]);
                $array_map = array_map('strtolower', $explode);

                $transaction->setKeywords($array_map);

                $transactions[] = $transaction;
            }
        }

        return $transactions;
    }
}
