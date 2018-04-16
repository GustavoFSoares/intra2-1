<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\LinkModel;

class LinkController extends AbstractController
{
    public function __construct(){
        parent::__construct(new LinkModel());
    }

    // public function get($req, $res, $args){
    //     die('123');
    //     parent::get($req, $res, $args);
    // }
}