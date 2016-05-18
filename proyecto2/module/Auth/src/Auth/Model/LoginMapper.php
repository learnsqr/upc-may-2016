<?php
namespace Auth\Model;

use Auth\Model\LoginEntity;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class LoginMapper
{

    protected $adapterMaster;
    protected $adapterSlave;
    
    private $tableName      = 'users';
    private $entity         = 'Auth\Model\LoginEntity';    
    private $hydrator       = 'Zend\Stdlib\Hydrator\Reflection';
    
    
    public function __construct($adapterSlave)
    {
        $this->adapterSlave = $adapterSlave;
    }
    
    public function fetch($email, $password)
    {
        $action = new Select($this->tableName);
        $password = md5($email);
        $action->where(array('email' => $email, 'password' => $password));
       
        //echo $action->getSqlString();
        
        $class = new \ReflectionClass($this->entity);
        $entity = $class->newInstance();
    
        $class = new \ReflectionClass($this->hydrator);
        $hydrator = $class->newInstance();
    
        $statement = $this->adapterSlave->createStatement();
        $action->prepareStatement($this->adapterSlave, $statement);
        $driverResult = $statement->execute();
    
        $resultset = new HydratingResultSet;
        $resultset->setHydrator($hydrator);
        $resultset->setObjectPrototype($entity);
        $resultset->initialize($driverResult);
        
        return $resultset->current();
    }
    
  
    
    
}