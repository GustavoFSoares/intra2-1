<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\LinkModel;

/**
 * <b>LinktController</b>
 * Classe responsável pelas Modificações e Interações com Links de Acesso</i>
 */
class LinkController extends ControllerAbstract
{
    public function __construct()
    {
        parent::__construct(new LinkModel());
    }

}