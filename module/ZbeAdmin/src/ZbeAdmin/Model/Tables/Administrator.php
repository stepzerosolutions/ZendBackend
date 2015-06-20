<?php
namespace ZbeAdmin\Model\Tables;



/** 
 * @author D.N.N Udugala
 * Administrator database table model
 */
class Administrator {
	public $id;
	public $email;
	public $password;
	public $resetpassword;
	public $resetdate;
	
	public function exchangeArray($data)
	{
		$this->id    = (isset($data['id'])) ? $data['id'] : null;
		$this->email = (isset($data['email'])) ? $data['email'] : null;
		$this->password = (isset($data['password'])) ? $data['password'] : null;
		$this->salt = (isset($data['salt'])) ? $data['salt'] : null;
		$this->resetpassword  = (isset($data['resetpassword'])) ? $data['resetpassword'] : null;
		$this->resetdate = (isset($data['resetdate'])) ? $data['resetdate'] : null;
	}
}