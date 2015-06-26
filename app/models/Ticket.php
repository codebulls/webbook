<?php

class Ticket extends BaseModel
{
  public function initialize()
  {
    $this->belongsTo('user_id', 'User', 'id');
    $this->belongsTo('webbook_id', 'Webbook', 'id');
  }
}
