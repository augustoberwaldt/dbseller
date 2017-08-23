<?php

namespace Dbseller\Provider;
/**
 * Classe responsavel por fazer as  opera��es no MongoDB
 *
 * @author Augusto Berwaldt <augusto.marlon@moovin.com.br>
 */
class ProviderMongo
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
     * MongoDriver constructor.
     * @param $dbname
     */

    protected  function __construct() {}

    /**
     * Realiza conexao com banco mongodb
     *
     * @param $dbname
     * @return DriverMongo
     */
    public  static function   getConnection($dbname)
    {
        if (!isset(self::$conn)) {
            self::$conn = (new ProviderMongo())
                ->setDatabase($dbname)
                ->setConnection(
                    new \MongoClient(self::HOST_MONGODB, [
                        'socketTimeoutMS' => self::TIMEOUT
                    ])
                );
        }

        return self::$conn;
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
    public function  setConnection(\MongoClient $connection) {
          $this->connection = $connection;
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
            ->selectDB($this->database)
            ->selectCollection($this->getCollectionName());
    }

    /**
     * Persiste  um array de dados no MongoDb.
     *
     *@param array $data
     *@return boolean
     */
    public function  persist(array $data)
    {
        try {
            $save = $this->getCollection()->insert($data);
        } catch(MongoCursorException $e) {
            return false;
        }

        return ($save['ok'] == 1);
    }

    /**
     * Persiste  varios array de dados no MongoDb.
     *
     * @param array $data
     * @return bool
     */
    public function  persistAll(array $data)
    {
        try {
            $save = $this->getCollection()->batchInsert($data);
        } catch(MongoCursorException $e) {
            return false;
        } catch (MongoCursorTimeoutException $et) {
            return false;
        }

        return ($save['ok'] == 1);
    }


    /**
     * Atualiza dados no mongoDb
     *
     * @param array $filter
     * @param array $data
     * @return bool
     */
    public  function update(array  $filter, array $data)
    {
        try {
            $updated = $this->getCollection()->update($filter, $data);
        } catch(MongoCursorException $e) {
            return false;
        }

        return ($updated['ok'] == 1);
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
        $offset = $options['offset'];
        $limit  = $options['limit'];
        $order  = $options['order'];
        unset($options['offset'],
            $options['limit'],
            $options['order']
        );


        $cursor = $this->getCollection()->find($options);
        $this->totalRows = $cursor->count();
        if (!empty($offset)) {
            $cursor = $cursor->skip($offset);
        }

        if (!empty($order)) {
            $cursor->sort($order);
        }

        if (!empty($limit)) {
            $cursor = $cursor->limit($limit);
        }

        if ($typeArray) {
            return iterator_to_array($cursor);
        }

        return $cursor;
    }

    /**
     * Retorna total linhas tabela.
     *
     * @param  array  $options
     *@return integer
     */
    public function getTotalRows(array $options = [])
    {
        return $this->find($options)->count();
    }

    /**
     *Deleta a coleção e exclui seus índices.
     *
     *@return boolean
     */
    public  function drop()
    {
        $response = $this->getCollection()
                        ->drop();
        
        return $response['ok'] == 1 ? true : false;
    }

    /**
     * Cria indice  numa collection no mongo
     *
     * @param $fields
     * @param bool $unique
     * @return mixed
     */
    public function createIndex($fields, $unique = true)
    {
        return $this->getCollection()
            ->createIndex($fields, ['unique' => $unique]);

    }

}