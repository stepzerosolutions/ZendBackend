<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZbeAdmin for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZbeAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\Result as Result;
use ZbeAdmin\Form\LoginForm;
use Zend\view\Model\ViewModel;
use ZbeAdmin\Model\LoginValidation;
use ZbeCore\Model\zbeMessage;



class AdminController extends AbstractActionController
{
    protected $authService;
    
    public function __construct(){
        $this->authService = new AuthenticationService();
    }
    
    public function indexAction()
    {
        $auth = new AuthenticationService();
        if( $this->authService->hasIdentity() ){
            $configdata = $this->getServiceLocator()->get('config');
            return $this->redirect()->toRoute( 'zbeadmin/dashboard' );
        }
        $form = new LoginForm();
        return array('form' => $form );
    }
    
    public function loginAction(){
        $request = $this->getRequest();
        $message = new zbeMessage();
        
        if( $request->isPost() ){
            $loginForm = new LoginForm();
            $inputFilter = new LoginValidation();
            $loginForm->setInputFilter( $inputFilter->getInputFilter() );
            $loginForm->setData( $request->getPost() );
            $translator = $this->getServiceLocator()->get('translator');
                
            if( $loginForm->isValid() ){
                $post = $request->getPost();
                $configdata = $this->getServiceLocator()->get('config');
                $username = $post['userlogin'];
                $salt = md5( $username );
                $password = md5( $configdata["production"]["encription_key"].$post['pw'].$salt ) ;
                
                $adapter = $this->getServiceLocator()->get('DbAdapter');
                $authadapter = new AuthAdapter($adapter);
                // configure auth adapter
                $authadapter->setTableName( $configdata["production"]["db"]["params"]["prefix"]."administrator" )
                ->setIdentityColumn('email')
                ->setCredentialColumn('password');
                
                // pass authentication information to auth adapter
                $authadapter->setIdentity( $username )
                ->setCredential( $password );
                
                // create auth service and set adapter
                // auth services provides storage after authenticate
                $this->authService->setAdapter($authadapter);
                
                
                // authenticate
                $result = $this->authService->authenticate();
                
                // check if authentication was successful
                // if authentication was successful, user information is stored automatically by adapter
                if ($result->isValid()) {
                    // redirect to user index page
                    return $this->redirect()->toRoute( 'zbeadmin/dashboard' );
                } else {
                    switch ($result->getCode()) {
                        case Result::FAILURE_IDENTITY_NOT_FOUND:
                            $msg = $translator->translate('Incorrect user email or password');
                            break;
                
                        case Result::FAILURE_CREDENTIAL_INVALID:
                            $msg = $translator->translate('Invalid credentials');
                            break;
                
                        case Result::SUCCESS:
                            $msg = 'SUCCESS';
                            break;
                
                        default:
                            $msg = $translator->translate('Incorrect user email or password');
                            break;
                    }
                    $message->setError( $msg );
                    $this->redirectAdminIndex();
                }
                //$authadapter = new Authentication( $adapter, $post['username'],  $password );
                //$this->redirect()->toRoute('bbv', array( 'action' => 'index'));
                //$result = $this->auth->authenticate($authadapter);
                
            } else {
                $message->setError("faliure to validate");
                $this->redirectAdminIndex();
            }
        } 
        $this->redirectAdminIndex();
    }
    
    
    public function dashboardAction(){
        $this->authService = new AuthenticationService();
        if( ! $this->authService->hasIdentity() ){
            $this->redirectAdminIndex();
        } 
        $layout = $this->layout();
        $layout->setTemplate('admin/dashboard/layout');
    }
    
    
    public function logoutAction(){
        if( $this->authService->hasIdentity() ){
            $this->authService->clearIdentity();
        }
        $this->redirectAdminIndex();
    }
    

    public function layoutAction(){
        $this->authService = new AuthenticationService();
        if( ! $this->authService->hasIdentity() ){
            $this->redirectAdminIndex();
        }
        $layoutManager = $this->getServiceLocator()->get('layoutManager');
        var_dump( $layoutManager->setXmlLayoutPath() );
        die();
    }
    
    public function redirectAdminIndex(){
        return $this->redirect()->toRoute( 'zbeadmin' );
    }

}
