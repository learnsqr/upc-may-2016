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
        $request = $this->getRequest();        
        $method = $request->getMethod();        
        switch ($method)
        {
            case 'GET':
                $id = (int)$this->params('id');
                if (!$id) {
                    return $this->get($id);
                }
                else
                    return $this->getAll();
            break;
            case 'POST':
                break;
            case 'PATCH':
                break;
            case 'DELETE':
                break;
            case 'OPTIONS':
                break;
            default:
                $this->getall();
            break;
            
        }
       
        die;
    }
    
    public function getAll()
    {
        $mapper = $this->getServiceLocator()->get('Album\Model\AlbumMapper');
        $data = $mapper->fetchAll();

        $response = $this->getResponse();
        $response->setStatusCode(200);
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $response->setContent(json_encode((array)$data->getCurrentItems()));
        return $response;    
    }
    
    public function get($id)
    {        
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
            return $this->redirect()->toRoute('task', array('action'=>'add'));
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
    