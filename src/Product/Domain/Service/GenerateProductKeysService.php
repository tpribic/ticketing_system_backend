<?php

declare(strict_types=1);

namespace App\Product\Domain\Service;


use App\Product\Domain\Model\Product;

final class GenerateProductKeysService
{
    public function generateSerialNumber()
    {
        $template   = 'XX99-XX99-99XX-99XX-XXXX-99XX';
        $templateLength = strlen($template);
        $generatedKey = '';
        for ($i=0; $i<$templateLength; $i++)
        {
            switch($template[$i])
            {
                case 'X': $generatedKey .= chr(rand(65,90)); break;
                case '9': $generatedKey .= rand(0,9); break;
                case '-': $generatedKey .= '-';  break;
            }
        }
        return $generatedKey;
    }

    public function generateActivationKeyForModel()
    {
        return uniqid();
    }
}