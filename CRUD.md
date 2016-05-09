# Configuracion de apache

1 .AllowOverride None
2. AllowOverride FileInfo

# Applicacion SKELETON

Crear el proyecto con SKELETOn
 php composer.phar create-project --stability="dev" zendframework/skeleton-application path/to/install

 php composer.phar self-update
 php composer.phar install
 
 COMPOSER_PROCESS_TIMEOUT=5000 php composer.phar install

# CRUD

List of albums 	
Add new album 	
Edit album 
Delete album

id 	integer 	No 	Primary key, auto-increment
artist 	varchar(100) 	No 	 
title 	varchar(100) 	No 	


# Bootstrap

<code>
<?php

 /**
  * Display all errors when APPLICATION_ENV is development.
  */
 if ($_SERVER['APPLICATION_ENV'] == 'development') {
     error_reporting(E_ALL);
     ini_set("display_errors", 1);
 }

 /**
  * This makes our life easier when dealing with paths. Everything is relative
  * to the application root now.
  */
 chdir(dirname(__DIR__));

 // Decline static file requests back to the PHP built-in webserver
 if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
     return false;
 }

 // Setup autoloading
 require 'init_autoloader.php';

 // Run the application!
 Zend\Mvc\Application::init(require 'config/application.config.php')->run();
 
 </code>
 
 # Module Album
 /module/Album/Module.php
 
 <code>
  namespace Album;

 use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
 use Zend\ModuleManager\Feature\ConfigProviderInterface;

 class Module implements AutoloaderProviderInterface, ConfigProviderInterface
 {
     public function getAutoloaderConfig()
     {
         return array(
             'Zend\Loader\ClassMapAutoloader' => array(
                 __DIR__ . '/autoload_classmap.php',
             ),
             'Zend\Loader\StandardAutoloader' => array(
                 'namespaces' => array(
                     __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                 ),
             ),
         );
     }

     public function getConfig()
     {
         return include __DIR__ . '/config/module.config.php';
     }
 }
 </code>
 
#AUTOLOAD
 /module/Album/autoload_classmap.php

<code>
 return array();
</code>


# CONFIG
 /module/Album/config/module.config.php
 <code>
 return array(
     'controllers' => array(
         'invokables' => array(
             'Album\Controller\Album' => 'Album\Controller\AlbumController',
         ),
     ),
     'view_manager' => array(
         'template_path_stack' => array(
             'album' => __DIR__ . '/../view',
         ),
     ),
 );
 </code>


# ADD MODULE
/config/application.config.php

<code>
return array(
     'modules' => array(
         'Application',
         'Album',                  // <-- Add this line
     ),
     'module_listener_options' => array(
         'config_glob_paths'    => array(
             'config/autoload/{{,*.}global,{,*.}local}.php',
         ),
         'module_paths' => array(
             './module',
             './vendor',
         ),
     ),
 );
</code>

 # ROUTER
 
Home 	          AlbumController 	index
Add new album 	AlbumController 	add
Edit album 	    AlbumController 	edit
Delete album 	  AlbumController 	delete

Add to 
 /module/Album/config/module.config.php

<code>
'controllers' => array(
         'invokables' => array(
             'Album\Controller\Album' => 'Album\Controller\AlbumController',
         ),
     ),
     
'router' => array(
         'routes' => array(
             'album' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/album[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Album\Controller\Album',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

</code>


/album 	          Home (list of albums) 	      index
/album/add 	      Add new album 	              add
/album/edit/2 	  Edit album with an id of 2 	  edit
/album/delete/4 	Delete album with an id of 4 	delete


# CONTROLLER
/module/Album/src/Album/Controller/AlbumController.php

<code>
namespace Album\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;

 class AlbumController extends AbstractActionController
 {
     public function indexAction()
     {
     }

     public function addAction()
     {
     }

     public function editAction()
     {
     }

     public function deleteAction()
     {
     }
 }
 </code>
 
 # CREATE VIEWS
 
    /module/Album/view/album/album/index.phtml
    /module/Album/view/album/album/add.phtml
    /module/Album/view/album/album/edit.phtml
    /module/Album/view/album/album/delete.phtml

 
 
 #DATABASE
 <code>
  CREATE TABLE album (
   id int(11) NOT NULL auto_increment,
   artist varchar(100) NOT NULL,
   title varchar(100) NOT NULL,
   PRIMARY KEY (id)
 );
 INSERT INTO album (artist, title)
     VALUES  ('The  Military  Wives',  'In  My  Dreams');
 INSERT INTO album (artist, title)
     VALUES  ('Adele',  '21');
 INSERT INTO album (artist, title)
     VALUES  ('Bruce  Springsteen',  'Wrecking Ball (Deluxe)');
 INSERT INTO album (artist, title)
     VALUES  ('Lana  Del  Rey',  'Born  To  Die');
 INSERT INTO album (artist, title)
     VALUES  ('Gotye',  'Making  Mirrors');
     
</code>



# DATABASE ACCESS - MODELS

/module/Album/src/Album/Model/Album.php

<code>
namespace Album\Model;

 class Album
 {
     public $id;
     public $artist;
     public $title;

     public function exchangeArray($data)
     {
         $this->id     = (!empty($data['id'])) ? $data['id'] : null;
         $this->artist = (!empty($data['artist'])) ? $data['artist'] : null;
         $this->title  = (!empty($data['title'])) ? $data['title'] : null;
     }
 }
</code>



/module/Album/src/Album/Model/AlbumTable.php

<code>
 namespace Album\Model;

 use Zend\Db\TableGateway\TableGateway;

 class AlbumTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function getAlbum($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveAlbum(Album $album)
     {
         $data = array(
             'artist' => $album->artist,
             'title'  => $album->title,
         );

         $id = (int) $album->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getAlbum($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Album id does not exist');
             }
         }
     }

     public function deleteAlbum($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }
</code>

#SERVICE MANAGER TO D.I

/module/Module.php


<code>
 namespace Album;

 // Add these import statements:
 use Album\Model\Album;
 use Album\Model\AlbumTable;
 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;

 class Module
 {
     // getAutoloaderConfig() and getConfig() methods here

     // Add this method:
     public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'Album\Model\AlbumTable' =>  function($sm) {
                     $tableGateway = $sm->get('AlbumTableGateway');
                     $table = new AlbumTable($tableGateway);
                     return $table;
                 },
                 'AlbumTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Album());
                     return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }
 }

</code>


#DATABASE CONFIGURATION

/config/autoload/global.php

<code>
return array(
     'db' => array(
         'driver'         => 'Pdo',
         'dsn'            => 'mysql:dbname=zf2tutorial;host=localhost',
         'driver_options' => array(
             PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
         ),
     ),
     'service_manager' => array(
         'factories' => array(
             'Zend\Db\Adapter\Adapter'
                     => 'Zend\Db\Adapter\AdapterServiceFactory',
         ),
     ),
 );
 </code>
 
 /config/autoload/local.php
 
 <code>
 return array(
     'db' => array(
         'username' => 'YOUR USERNAME HERE',
         'password' => 'YOUR PASSWORD HERE',
     ),
 );
 
 </code>
 
 
 
 # INJECT TO CONTROLLER GET ALBUM
 
 <code>

protected $albumTable;

 public function getAlbumTable()
     {
         if (!$this->albumTable) {
             $sm = $this->getServiceLocator();
             $this->albumTable = $sm->get('Album\Model\AlbumTable');
         }
         return $this->albumTable;
     }
 </code>
 
 
 # View Albums
 
 <code>
 public function indexAction()
     {
         return new ViewModel(array(
             'albums' => $this->getAlbumTable()->fetchAll(),
         ));
     }
 
 </code>
 
