<?php
namespace Album\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Album\Form\AlbumFilter;

class AlbumForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('album');
        $this->setAttribute('method', 'post');
        $this->setInputFilter(new AlbumFilter());
        $this->setHydrator(new ClassMethods());
        
        
        $this->add(array(
            'name' => 'id',
            'type' => 'hidden',
        ));
        
        $this->add(array(
            'name' => 'title',
            'type' => 'text',
            'options' => array(
                'label' => 'Title',
            ),
            'attributes' => array(
                'id' => 'title',
                'maxlength' => 100,
            )
        ));
        $this->add(array(
            'name' => 'artist',
            'type' => 'text',
            'options' => array(
                'label' => 'Artista',
            ),
            'attributes' => array(
                'id' => 'artist',
                'maxlength' => 255,
            )
        ));
        
       
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'class' => 'btn btn-primary',
            ),
        ));
    }
}