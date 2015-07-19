<?php
namespace ZbeAdmin\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 *
 * @author wasana
 *        
 */
class LoginValidation implements InputFilterAwareInterface
{
    protected $inputfilter;
    
    public function exchangeArray($data){
        $this->userlogin     = (isset($data['userlogin']))     ? $data['userlogin']     : null;
        $this->pw = (isset($data['pw'])) ? $data['pw'] : null;
    }
    
    public function setInputFilter( InputFilterInterface $inputfilter){
        throw new \ErrorException("Loginvalidation set input filter is disabled");
    }
    
    public function getInputFilter(){
        if( !$this->inputfilter ){
            $inputfilter = new InputFilter();
            $inputfilter->add(array(
                'name'     => 'userlogin',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'EmailAddress',
                    ),
                    array(
                        'name' => 'not_empty',
                    ),
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 5,
                            'max'      => 30,
                        ),
                    ),
                ),
                
            ));
            $inputfilter->add(array(
                'name'     => 'pw',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'not_empty',
                    ),
                    array(
                        'name' => 'string_length',
                        'options' => array(
                            'min' => 6,
                            'max' => 12
                        ),
                    ),
                ),
            ));
            $this->inputfilter = $inputfilter;
        }
        return $this->inputfilter;;
    }
}