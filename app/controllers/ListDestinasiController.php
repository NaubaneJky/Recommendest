<?php
class ListDestinasiController{
    private $model;

    public function __construct(){
        $this->model = new Destinasi();
    }

    public function getListDestinasi(){
        return $this->model->getListDestinasi();
    }
}