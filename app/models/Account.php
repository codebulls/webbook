<?php

class Account extends BaseModel
{
	public function initialize()
    {
        $this->belongsTo('user_id', 'Users', 'id');
        $this->belongsTo('tariff_id', 'Tariff', 'id');
    }
}