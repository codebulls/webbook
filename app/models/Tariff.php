<?php

class Tariff extends BaseModel
{
    public static function getTariff($tid)
    {
        $tariff = Tariff::findFirstById($tid);
        return $tariff;
    }
}
