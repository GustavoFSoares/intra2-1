<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\LinkModel;

/**
 * <b>ScriptController</b>
 * Classe responsável pela execução dos Scripts contido na pasta <i>src/HospitalApi/Scripts</i>
 */
class ScriptController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new LinkModel());
    }

}