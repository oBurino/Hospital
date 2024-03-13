<?php

class Database {

    /**
     * @var PDO
     */
    public $Connection;

    /**
     * @var string
     */
    private $driver;

    /**
     * @return string
     */
    public function getDriver(): string {
        return $this->driver;
    }

    /**
     * @param string $driver
     * @return void
     */
    public function setDriver(string $driver): void {
        $this->driver = $driver;
    }

    /**
     * @var string
     */
    private $hostname;

    /**
     * @return string
     */
    public function getHostname(): string {
        return $this->hostname;
    }

    /**
     * @param string $hostname
     * @return void
     */
    public function setHostname(string $hostname): void {
        $this->hostname = $hostname;
    }

    /**
     * @var int
     */
    private $port;

    /**
     * @return int
     */
    public function getPort(): int {
        return $this->port;
    }

    /**
     * @param int $port
     * @return void
     */
    public function setPort(int $port): void {
        $this->port = $port;
    }

    /**
     *
     * @var string
     */
    private $username;

    /**
     * @return string
     */
    public function getUsername(): string {
        return $this->username;
    }

    /**
     * @param string $username
     * @return void
     */
    public function setUsername(string $username): void {
        $this->username = $username;
    }

    /**
     * @var string
     */
    private $password;

    /**
     * @return string
     */
    public function getPassword(): string {
        return $this->password;
    }

    /**
     * @param string $password
     * @return void
     */
    public function setPassword(string $password): void {
        $this->password = $password;
    }

    /**
     * @var string
     */
    private $database;

    /**
     * @return string
     */
    public function getDatabase(): string {
        return $this->database;
    }

    /**
     * @param string $database
     * @return void
     */
    public function setDatabase(string $database): void {
        $this->database = $database;
    }

   
    public function __construct() {
           $this->setDriver("mysql");
        $this->setHostname("127.0.0.1");
        $this->setPort(3306);
        $this->setUsername("root");
        $this->setPassword("");
        $this->setDatabase("hospital_santa_house");
    }

    
    public function Conectar() {
        $status = "NCONN";
        
        $dataSource = "{$this->getDriver()}:host={$this->getHostname()};dbname={$this->getDatabase()}";

        try {
       
            $this->Connection = new PDO($dataSource, $this->getUsername(), $this->getPassword());

     
            if (is_object($this->Connection) && $this->Connection instanceof PDO) {
                $this->Connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $status = "CONN";
            }
        } catch (PDOException $Error) {
            $status = $Error->getCode();
        }

        return $status;
    }
}


