<?php declare(strict_types = 1);

namespace Gaua;

class Rounder
{
    public function up(float $amount) : float
    {
        return ceil($amount * 100) / 100;
    }

    public function down(float $amount) : float
    {
        return floor($amount * 100) / 100;
    }
}