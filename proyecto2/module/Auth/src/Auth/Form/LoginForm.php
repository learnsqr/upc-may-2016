<?php
namespace Auth\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Auth\Form\LoginFilter;

class LoginForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('auth');
        $this->setAttribute('method', 'post');
        $this->setInputFilter(new LoginFilter());
        $this->setHydrator(new ClassMethods());
        
        
        
        $this->add(array(
            'name' => 'email',
            'type' => 'text',
            'options' => array(
                'label' => 'Email',
            ),
            'attributes' => array(
                'id' => 'email',
                'maxlength' => 100,
            )
        ));
        $this->add(array(
            'name' => 'password',
            'type' => 'text',
            'options' => array(
                'label' => 'Password',
            ),
            'attributes' => array(
                'id' => 'password',
                'maxlength' => 255,
            )
        ));
        
       
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Login',
                'class' => 'btn btn-primary',
            ),
        ));
    }
}