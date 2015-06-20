<?php
namespace ZbeCore\Model\Tables;

/** 
 * @author D.N.N Udugala
 * 
 */
use Zend\Db\TableGateway\TableGateway;

class ConfigurationTable {
	protected $tableGateway;
	protected $select;
	
	
	public function __construct(TableGateway $tableGateway){
		$this->tableGateway = $tableGateway;

	}
	
	public function fetchAll(){
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	
	public function getByName($name){
		$name  = (string)$name;
		$rowset = $this->tableGateway->select(
				array('name' => $name)
		);
		$row = $rowset->current();
		if (!$row) {
			return false;
		}
		return $row;
	}

	
	public function getValueByName($name){
		$name  = (string)$name;
		
		$sql = $this->tableGateway->getSql()->select();
		$sql->columns( array( 'value') );
		$sql->where( array('name' => $name) );

		$rowset = $this->tableGateway->selectWith($sql);
		$row = $rowset->current();
		if (!$row) {
			return false;
		}
		return $row->value;
	}
	
	
	public function deleteByName($name){
		$this->tableGateway->delete( array('name' => $name) );
	}
	
	
	public function updateConfig( $name, $value ){
	    $sql = $this->getValueByName($name);
	    if( !$sql ){
	        $this->tableGateway->getSql()->insert( array($name => $value) );
	    } else {
	       $this->tableGateway->getSql()->update( array($name => $value), ' name='. $name );
	    }
	}
	
	public function getByentity($entityName ){
	    
	}
}

?>