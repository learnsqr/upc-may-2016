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
    
    public function save(AlbumEntity $album)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($album);
    
        if ($album->id) {
            // update action
            $action = $this->sql->update();
            $action->set($data);
            $action->where(array('id' => $album->getId()));
        } else {
            // insert action
            $action = $this->sql->insert();
            unset($data['id']);
            $action->values($data);
        }
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
    
        if (!$album->id) {
            $album->id=$result->getGeneratedValue();
        }
        return $result;
    
    }
    
    public function getTask($id)
    {
        $select = $this->sql->select();
        $select->where(array('id' => $id));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
    
        $hydrator = new ClassMethods();
        $task = new TaskEntity();
        $hydrator->hydrate($result, $task);
    
        return $task;
    }
    
    public function deleteTask($id)
    {
        $delete = $this->sql->delete();
        $delete->where(array('id' => $id));
    
        $statement = $this->sql->prepareStatementForSqlObject($delete);
        return $statement->execute();
    }
    
    
}