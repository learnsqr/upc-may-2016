<?php
namespace Album\Model;

// use Zend\Db\Adapter\Adapter;
use Album\Model\albumEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
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
    
   
    public function fetchAll($filter=null)
    {    
        $select = new Select($this->tableName);
         
        /**
         * Filters
         */
    
        //         echo $select->getSqlString();
    
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
    
    
}