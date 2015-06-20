<?php
namespace ZbeAdmin\Form;

use Zend\Form\Form;
/**
 *
 * @author wasana
 *        
 */
class LoginForm extends Form
{
    public function __construct($name = null){
        parent::__construct();
        
        $this->add(array(
            'name' => 'secureprefix',
            'attributes' => array(
            				'type'  => 'hidden',
                'id' => 'secureprefix',
    				'class' => 'form-control input-admin',
    				'placeholder' => 'Password',
    				'autofocus' => 'autofocus'
            ),
        ));
        
        
        $this->add(array(
            'name' => 'userlogin',
            'type' => 'email',
            'attributes' => array(
                'class' => 'userlogin form-control',
                'id' => 'email',
                'required' => 'required'
            ),
            'options' => array( 'label' => 'Username')
        ));
        
        $this->add(array(
            'name' => 'pw',
            'type' => 'password',
            'attributes' => array(
                'class' => 'password form-control',
                'id' => 'password',
                'required' => 'required'
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Login',
                'id' => 'submitbutton',
            ),
        ));
    }   
}