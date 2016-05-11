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
        
        
//         $result = new ViewModel();
//         $result->setTerminal(true);
//         $result->setVariables(array('albums' => $data));
//         return $result;
        
        $response = $this->getResponse();
        $response->setStatusCode(200);

        $response->setContent($data);
        return $response;
      
    }
    
    public function apiAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('album', array('action'=>'add'));
        }
        $mapper = $this->getServiceLocator()->get('Album\Model\AlbumMapper');
        $data = $mapper->fetch($this->params('id'));
        
        
        $response = $this->getResponse();
        $response->setStatusCode(200);
      
        
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $response->setContent(json_encode((array)$data));
        return $response;
      
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
            return $this->redirect()->toRoute('album', array('action'=>'add'));
        }        
        $mapper = $this->getServiceLocator()->get('Album\Model\AlbumMapper');
        $data = $mapper->fetch($this->params('id'));
        
        $form = new AlbumForm();
        $form->bind($data);
        $form->setData((array)$data);
                
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $mapper->update($request->getPost(), $id);
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
    