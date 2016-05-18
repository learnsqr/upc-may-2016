<?php
namespace Album\Form;

use Zend\InputFilter\InputFilter;

class AlbumFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'id',
            'required' => true,
            'filters' => array(
                array('name' => 'Int'),
            ),
        ));
        $this->add(array(
            'name' => 'title',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 2,
                        'max' => 7,
                        'messages' => array(
                            'stringLengthTooShort' => 'Value between 2 to 100 character!'
                           
                        ),
                    ),
                ),
                array(
                    'name' =>'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Zend\Validator\NotEmpty::IS_EMPTY => 'Please enter User Name!'
                        ),
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name' => 'artist',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'max' => 100
                    ),
                ),
            ),
        ));
       
    }
}