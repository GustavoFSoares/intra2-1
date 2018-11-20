<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\OmbudsmanDemandsModel;

/**
 * <b>OmbudsmanController</b>
 */
class OmbudsmanController extends ControllerAbstractLongEntity
{
    public function __construct() {
        parent::__construct(new OmbudsmanDemandsModel());
    }

    public function printDocumentAction($req, $res, $args) {
        
        $params = $req->getParams();
        $documentTemplate = new \HospitalApi\Template\OmbudsmanDocumentTemplate();

        
        echo '<br><br>';
        echo '!!!'.__FILE__.':<b>'.__LINE__.'</b>'.'!!!';
        echo '<pre>';
        print_r($documentTemplate);
        echo '</pre>';
        die('');
        
    }


}