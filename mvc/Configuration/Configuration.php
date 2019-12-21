<?php


/**
 * Class Configuration
 *
 *
 *      Singleton class in charge of reading and serving application settings
 *
 */
class Configuration {

    /**
     * @var SimpleXMLElement $xml
     */
    private $xml;

    /**
     * @var Routes $routes
     */
    private $routes;

    /**
     * @var string $xmlFile
     */
    private static $xmlFile;

    /**
     * @var Configuration $instance
     */
    private static $instance;



    /**
     * @return Configuration
     */
    public static function getInstance() {

        if(empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }



    /**
     * @param string $xmlFile
     */

    public static function setXMLFilePath(string $xmlFile) {

        self::$xmlFile = $xmlFile;
    }

    /**
     * Configuration constructor.
     */
    public function __construct() {

        if(empty(self::$xmlFile)) {

            die("Path to the configuration file is not set!");
        } else {

            $this->xml = simplexml_load_file(self::$xmlFile);

            $this->routes = new Routes($this->xml->application->routes);
        }
    }

    public function __clone() {}

    public function getXML()
    {
        return $this->xml;
    }

    public function Routes()
    {
        return $this->routes;
    }


    public function getEnvironments()
    {
        return $this->xml->application->environments;
    }

    public function getServers()
    {
        return $this->xml->application->servers;
    }

    public function getViewsPath()
    {
        return (string) $this->xml->application->views_path['path'];
    }

    public function getCompilationsPath()
    {
        return (string) $this->xml->application->compilations_path['path'];
    }

    public function getListeners()
    {
        return $this->xml->application->listeners;
    }

    public function getModules()
    {
        return $this->xml->application->modules;
    }

    public function getMySQLConnectionData()
    {
        return $this->xml->application->server;
    }

}