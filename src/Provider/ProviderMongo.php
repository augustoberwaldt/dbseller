<?php

namespace Dbseller\Provider;
/**
 * Classe responsavel por fazer as  opera��es no MongoDB
 *
 * @author Augusto Berwaldt <augusto.berwaldt@gmail.com.br>
 */
class ProviderMongo extends Provider
{
    /** @const string PORT_HOST_MONGODB */
    const HOST_MONGODB = 'mongodb://127.0.0.1';

    /** @const Integer TIMEOUT */
    const TIMEOUT = 50000;


    /** @const string PORT_HOST_MONGODB */
    const PORT_HOST_MONGODB = '27017';

    /**
     * Nome do banco no Mongo.
     *
     * @access private
     * @name $database
     */
    private  $database ;

    /**
     * Vari�vel responsavel pela conexao com  MongoDb.
     *
     * @access private
     * @name $connection
     */
    private  $connection;
    /**
     * Vari�vel que contem o nome cole��o no MongoDb.
     *
     * @access private
     * @name $collectionName
     */
    private $collectionName;
    /**
     * Vari�vel que contem a instacia da class Mongocollection.
     *
     * @access private
     * @name $collection
     */
    private $collection;
    /**
     * Coment�rio de vari�veis
     *
     * @access private
     * @name $totalRows
     */
    private $totalRows;

    /**
     * conexao da $this class
     *
     * @access public
     * @name $conn
     */
    public  static $conn;

    /**
     * Gerencia driver
     *
     * @access private
     * @name $manager
     */
     private $manager;


    /**
     * MongoDriver constructor.
     *
     * @param $dbname
     */
    protected  function __construct() {}

    /**
     * Realiza conexao com banco mongodb
     *
     * @param $dbname
     * @return DriverMongo
     */
    public static function getConnection($dbname)
    {
        if (!isset(self::$conn)) {
            self::$conn = (new ProviderMongo())
                ->setDatabase($dbname)
                ->setConnection(
                    new \MongoDB\Client(self::HOST_MONGODB . ':'. self::PORT_HOST_MONGODB)
                );
        }

        return self::$conn;
    }

    /**
     * @param $database
     * @return $this
     */
    public  function  setManager(\MongoDB\Driver\Manager  $manager) {
        $this->manager = $manager;
        return $this;
    }

    /**
     * @return \MongoDB\Driver\Manager $manager
     */
    public  function  getManager() {

        return $this->manager;
    }

    /**
     * @param $database
     * @return $this
     */
     public  function  setDatabase($database) {
          $this->database = $database;
          return $this;
     }

    /**
     * atribui conexao setConnection
     *
     * @param \MongoClient $connection
     */
    public function  setConnection(\MongoDB\Client $connection) {
          $this->connection = $connection;
          $this->setManager($connection->getManager());
          return $this;
    }

    /**
     *
     *@param  string collection nome da colecao
     *@return MoovinNotications
     */
    public function  setCollectionName($collectionName)
    {
        $this->collectionName = $collectionName;
        return $this;
    }

    /**
     * Retorna o nome da collection
     *
     *@return string  nome da collection
     */
    public function  getCollectionName()
    {
        return $this->collectionName;
    }

    /**
     *Retorna uma instacia da class MongoCollection.
     *
     *@return MongoCollection
     */
    public function  getCollection()
    {
        return $this->connection
                    ->selectCollection($this->database, $this->getCollectionName());
    }

    /**
     * Persiste  um array de dados no MongoDb.
     *
     *@param array $data
     *@return boolean
     */
    public function  persist($data)
    {
        $bulkWriteManager = new \MongoDB\Driver\BulkWrite;

        try {
            $bulkWriteManager->insert($data);

        } catch(MongoCursorException $e) {
            return false;
        }

        $this->manager
             ->executeBulkWrite($this->getDbCollectionName(), $bulkWriteManager);
    }

    /**
     * atualiza  um array de dados no MongoDb.
     *
     *@param array $data
     *@param array $filter
     *@return boolean
     */
    public function  update($data, $filter)
    {
        $bulkWriteManager = new \MongoDB\Driver\BulkWrite;

        try {

            $query = ['$set' => $data];

            $bulkWriteManager->update($filter, $query);
        } catch(MongoCursorException $e) {
            return false;
        }

        $this->manager
            ->executeBulkWrite($this->getDbCollectionName(), $bulkWriteManager);
    }



    /**
     * Retorna  nome no formato do mongodb
     *
     * @return string
     */
    private function getDbCollectionName()
    {
        return $this->database. '.' .$this->getCollectionName();
    }

    /**
     * Realiza busca MongoDb.
     *
     *@param array $data
     *@param boolean $typeArray
     *@return mixed
     */
    public function  find(array $options , $typeArray = false)
    {
        $query = new \MongoDB\Driver\Query($options);
        $cursor = $this->manager->executeQuery($this->getDbCollectionName(),
            $query)->toArray();


        return $cursor;
    }

}