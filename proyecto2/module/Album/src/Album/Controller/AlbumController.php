<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AlbumController extends AbstractActionController
{
    public function indexsAction()
    {
        echo "aqui";
        
        $dmMaster = $this->getServiceLocator()->get('Album\Model\AlbumMapper');
        
        echo "<pre>";
        print_r($dmMaster);
        echo "</pre>";
            
        die;
        
        return new ViewModel();
    }
    
    
    public function indexAction()
    {
        $mapper = $this->getServiceLocator()->get('Album\Model\AlbumMapper');
        $data = $mapper->fetchAll();
        
        return new ViewModel(array('albums' => $data));
    }
    
    
    public function insertAction()
    {
        return new ViewModel();
    }
    
    public function updateAction()
    {
        return new ViewModel();
    }
    
    public function deleteAction()
    {
        return new ViewModel();
    }
}
    