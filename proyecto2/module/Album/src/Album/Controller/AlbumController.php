<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Model\AlbumEntity;
use Album\Form\AlbumForm;

class AlbumController extends AbstractActionController
{
    public function indexAction()
    {
        $mapper = $this->getServiceLocator()->get('Album\Model\AlbumMapper');
        $data = $mapper->fetchAll();
        
        return new ViewModel(array('albums' => $data));
    }
    
    public function addAction()
    {
        $form = new AlbumForm();
        $entity = new AlbumEntity();
        $form->bind($entity);
    
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $mapper = $this->getServiceLocator()->get('Album\Model\AlbumMapper');
                $mapper->save($entity);
    
                // Redirect to list 
                return $this->redirect()->toRoute('album');
            }
        }
    
        return array('form' => $form);
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
    