<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Model\AlbumEntity;
use Album\Form\AlbumForm;
use Zend\Form\FormInterface;

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
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $mapper = $this->getServiceLocator()->get('Album\Model\AlbumMapper');
                $mapper->insert($form->getData());
    
                // Redirect to list 
                return $this->redirect()->toRoute('album');
            }
        }
    
        return array('form' => $form);
    }
    public function editAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('task', array('action'=>'add'));
        }        
        $mapper = $this->getServiceLocator()->get('Album\Model\AlbumMapper');
        $data = $mapper->fetch($this->params('id'));

        
        echo "<pre>";
        print_r((array)$data);
        echo "</pre>";
        
        
        $form = new AlbumForm();
        $form->bind($data);
    
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $mapper->update($data);
                return $this->redirect()->toRoute('album');
            }
        }
    
        return array(
            'id' => $id,
            'form' => $form,
        );
    }
    
   
    
    public function deleteAction()
    {
    	$id = $this->params('id');
    	
    	$mapper = $this->getServiceLocator()->get('Album\Model\AlbumMapper');
    	$data = $mapper->fetch($this->params('id'));
    	
    	if (!$data) {
    		return $this->redirect()->toRoute('album');
    	}    
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		if ($request->getPost()->get('del') == 'Yes') {
    		    $mapper->delete($id);
    		}    
    		return $this->redirect()->toRoute('album');
    	}
    
    	return array(
    			'id' => $id,
    			'album' => $data
    	);
    }
}
    