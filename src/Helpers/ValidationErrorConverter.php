<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 27.03.19
 * Time: 13:05
 */

namespace Helpers;


class ValidationErrorConverter
{
    public function convert(array $errors): array
    {
        $result = [];

        foreach ($errors as $attribute => $errorBag) {
            $result[0][] = $this->getFirstErrorMessage($errorBag);
        }

        return $result;
    }

    private function getFirstErrorMessage(array $errorBag)
    {
        return $errorBag[0];
    }
}