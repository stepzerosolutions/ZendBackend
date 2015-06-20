<?php
namespace ZbeCore\Model\Tables;


/** 
 * @author D.N.N Udugala
 * Configuration database table model
 */
class Configuration {
	public $id;
	public $name;
	public $value;
	
	public function exchangeArray($data)
	{
		$this->id    = (isset($data['id'])) ? $data['id'] : null;
		$this->name = (isset($data['name'])) ? $data['name'] : null;
		$this->value = (isset($data['value'])) ? $data['value'] : null;
		$this->entity = (isset($data['entity'])) ? $data['entity'] : null;
	}
}

?>