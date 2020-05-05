<?php
declare(strict_types=1);

namespace App\Classes;

class Logger
{
    public function error(string $errorMessage, array $exceptionArray): void
    {
        echo "------------------------------<br>";
        echo "Some problem: $errorMessage<br>\n";
        print_r($exceptionArray);
        echo "------------------------------<br>";
    }
}