<?php

class Director {
  public $id = 0;

  function __construct($id) {
    $this->id = (int) $id;
  }
}
