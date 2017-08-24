<?php
namespace Dbseller\Entity;

/**
 * @author Augusto Berwaldt  <augusto.berwaldt@gmail.com>
 */
class Job
{
    /**
     * @var  $id
     */
    private $id;

    /**
     * @var  $title
     */
    private $title;

    /**
     * @var
     */
    private $created;

    /**
     * @var
     */
    private $lastExec;
    /**
     * @var
     */
    private $timer;

    /**
     * @var
     */
    private $type;

    /**
     *
     * @var
     */
    private $pathExec;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function set_Id($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $crated
     */
    public function setCreated($crated)
    {
        $this->created = $crated;
    }

    /**
     * @return mixed
     */
    public function getLastExec()
    {
        return $this->lastExec;
    }

    /**
     * @param mixed $lastExec
     */
    public function setLastExec($lastExec)
    {
        $this->lastExec = $lastExec;
    }

    /**
     * @return mixed
     */
    public function getTimer()
    {
        return $this->timer;
    }

    /**
     * @param mixed $timer
     */
    public function setTimer($timer)
    {
        $this->timer = $timer;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getPathExec()
    {
        return $this->pathExec;
    }

    /**
     * @param mixed $pathExec
     */
    public function setPathExec($pathExec)
    {
        $this->pathExec = $pathExec;
    }


}