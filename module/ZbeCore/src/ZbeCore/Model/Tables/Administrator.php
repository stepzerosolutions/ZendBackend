<?php
namespace ZbeCore\Model\Tables;



/** 
 * @author D.N.N Udugala
 * Administrator database table model
 */
class Administrator {
	public $admin_id;
	public $admin_email;
	public $admin_password;
	public $admin_status;
	public $admin_nickname;
	public $admin_registered;
	public $admin_level;
	
	public function exchangeArray($data)
	{
		$this->admin_id    = (isset($data['admin_id'])) ? $data['admin_id'] : null;
		$this->admin_email = (isset($data['admin_email'])) ? $data['admin_email'] : null;
		$this->admin_password = (isset($data['admin_password'])) ? $data['admin_password'] : null;
		$this->admin_status  = (isset($data['admin_status'])) ? $data['admin_status'] : null;
		$this->admin_nickname = (isset($data['admin_nickname'])) ? $data['admin_nickname'] : null;
		$this->admin_registered  = (isset($data['admin_registered'])) ? $data['admin_registered'] : null;
		$this->admin_level  = (isset($data['admin_level'])) ? $data['admin_level'] : null;
	}
}

?>