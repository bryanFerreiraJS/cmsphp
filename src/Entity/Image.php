<?php


namespace Entity;


class Image extends BaseEntity
{
    private $id;
    private $basePath = '/Public/Images/';
    private $name;
    private $absUrl;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function buildUrl()
    {
        if ($this->absUrl) {
            return $this->absUrl;
        }
        $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
        return $protocol . $_SERVER['HTTP_HOST'] . str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname(__DIR__) . $this->basePath) . $this->name;
    }

    public function getAbsUrl()
    {
        return $this->absUrl;
    }

    public function setAbsUrl($absUrl): void
    {
        $this->absUrl = $absUrl;
    }
}