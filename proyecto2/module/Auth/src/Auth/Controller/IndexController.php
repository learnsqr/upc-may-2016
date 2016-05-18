<?php
namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Auth\Model\LoginEntity;
use Auth\Form\LoginForm;
use Zend\Form\FormInterface;

class IndexController extends AbstractActionController
{
    
   
    
    public function indexAction()
    {
        
        echo "kaka";
        
         
        $form = new LoginForm();
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $mapper = $this->serviceLocator->get('Auth\Model\LoginMapper');
                $user = $mapper->fetch($form->getData()['email'], $form->getData()['password']);
      
                $_SESSION['loggedUser'] = $user;
                echo "<pre>";
                print_r($_SESSION);
                echo "</pre>";
                
                if(isset($_SESSION['loggedUser']->iduser)
                    && $_SESSION['loggedUser']->iduser!=='')
                {
                    return $this->redirect()->toRoute('login', array('action'=>'admin'));
                }
                else
                    return $this->redirect()->toRoute('home');
                
                // Redirect to list 
                
            }
        }
    
        return array('form' => $form);
      
    }
    
    public function logoutAction()
    {
        
        $_SESSION['loggedUser']=null;
        return $this->redirect()->toRoute('home');
        
    }
    public function adminAction()
    {

        $this->layout('admin');
    }
    
}