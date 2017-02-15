<?php declare(strict_types = 1);

namespace Gaua;

/** @codeCoeverageIgnore */
class DateProvider
{
    public function getCurrentDate() : string
    {
        return date('Y-m-d');
    }
}