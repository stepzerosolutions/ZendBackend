<?php
namespace ZbeCore\Model\Tables;

/** 
 * @author D.N.N Udugala
 * 
 */
use Zend\Db\TableGateway\TableGateway;

class AdministratorTable {
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway){
		$this->tableGateway = $tableGateway;
	}
	
	public function fetchAll(){
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}
	
	public function getAdministrator($id){
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(
				array('admin_id' => $id)
				);
		$row = $rowset->current();
		if (!$row) {
			return false;
		}
		return $row;
	}

	public function getAdministratorByEmail($email){
		$rowset = $this->tableGateway->select(
			array('admin_email' => $email )
		);
		$row = $rowset->current();
		if(!$rowset){
			return false;
		}
		return $row;
	}

	public function saveAdministrator(Administrator $administrator)
	{

	}
	
	public function deleteAdministrator($id){
		$this->tableGateway->delete( array('admin_id' => $id) );
	}
	
	public function resetPasswordByEmail( $email, $password ){
		
	}
}

?>