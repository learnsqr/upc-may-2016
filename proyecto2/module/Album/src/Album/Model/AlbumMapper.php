<?php
namespace Album\Model;

// use Zend\Db\Adapter\Adapter;
use Album\Model\albumEntity;
use Zend\Stdlib\Hydrator\ClassMethods;

use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Delete;

use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Paginator\Adapter\DbSelect;


class AlbumMapper
{

    protected $adapterMaster;
    protected $adapterSlave;
    
    private $tableName      = 'album';
    private $entity         = 'Album\Model\AlbumEntity';
    private $collection     = 'Album\Model\AlbumCollection';
    private $hydrator       = 'Zend\Stdlib\Hydrator\Reflection';
    
    
    public function __construct($adapterMaster, $adapterSlave)
    {
        $this->adapterMaster = $adapterMaster;
        $this->adapterSlave = $adapterSlave;
    }
    
    public function fetch($id)
    {
        $action = new Select($this->tableName);
        $action->where(array('id' => $id));
       
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
    
    public function fetchAll($filter=null)
    {    
        $select = new Select($this->tableName);
         
        /**
         * Filters
         */
    
        // echo $select->getSqlString();
    
        $class = new \ReflectionClass($this->entity);
        $entity = $class->newInstance();
    
        $class = new \ReflectionClass($this->hydrator);
        $hydrator = $class->newInstance();
    
        $statement = $this->adapterSlave->createStatement();
        $select->prepareStatement($this->adapterSlave, $statement);
        $driverResult = $statement->execute();
    
        $resultset = new HydratingResultSet;
        $resultset->setHydrator($hydrator);
        $resultset->setObjectPrototype($entity);
        $resultset->initialize($driverResult);
    
        $paginatorAdapter = new DbSelect(
            $select,
            $this->adapterSlave,
            $resultset
            );
    
        $class = new \ReflectionClass($this->collection);
        $collection = $class->newInstance($paginatorAdapter);
    
        return $collection;
    }
    
    public function insert($data)
    {
        $data = (array)$data;
           
        $class = new \ReflectionClass($this->entity);
        $entity = $class->newInstance();
    
        $class = new \ReflectionClass($this->hydrator);
        $hydrator = $class->newInstance();
    
        $hydrator->hydrate($data, $entity);
        $data = $hydrator->extract($entity);
    
        $action = new Insert($this->tableName);
        $action->values($data);
        //var_dump($action->getSqlString());
        $statement = $this->adapterMaster->createStatement();
        $action->prepareStatement($this->adapterMaster, $statement);
        $driverResult = $statement->execute();
        $hydrator->hydrate($data, $entity);
        
        return $entity;
    }
    
    public function update($data, $id)
    {
        $data = (array)$data;
         
        $class = new \ReflectionClass($this->entity);
        $entity = $class->newInstance();
    
        $class = new \ReflectionClass($this->hydrator);
        $hydrator = $class->newInstance();
    
        $hydrator->hydrate($data, $entity);
        $data = $hydrator->extract($entity);
    
        $action = new Update($this->tableName);
        $action->where(array('id'=>$id));
        $action->set($data);
       
        $statement = $this->adapterMaster->createStatement();
        $action->prepareStatement($this->adapterMaster, $statement);
        $driverResult = $statement->execute();
       
        $hydrator->hydrate($data, $entity);
    
        return $entity;
    }
    
    
    public function delete($id)
    {
        $action = new Delete($this->tableName);
        $action->where(array('id'=>$id));
       
        $statement = $this->adapterMaster->createStatement();
        $action->prepareStatement($this->adapterMaster, $statement);
        $driverResult = $statement->execute();
        
        return $driverResult;
    }
    
    
}