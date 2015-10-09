<?php

namespace Soluble\Japha\Db;

use Soluble\Japha\Bridge\PhpJavaBridge as Pjb;
use Soluble\Japha\Bridge\Exception;

class DriverManager
{
    /**
     *
     * @Java(java.sql.DriverManager)
     */
    protected $driverManager;
    

    public function __construct()
    {
    }
    
    /**
     * Return a JDBC DSN string
     *
     * @param string $db database name
     * @param string $host server ip or name
     * @param string $user username to connect
     * @param string $password password to connect
     * @param string $driverType diverType (mysql/oracle/postgres...)
     *
     * @return string
     */
    public static function getJdbcDsn($db, $host, $user, $password, $driverType = 'mysql')
    {
        return "jdbc:$driverType://$host/$db?user=$user&password=$password";
    }

    

    /**
     * Create an sql connection to database
     *
     * 
     * @throws Exception\ClassNotFoundException
     * @throws Exception\InvalidArgumentException
     * 
     * @param string $dsn
     * @param string $driverClass
     * @return Java(java.sql.Connection)
     */
    public function createConnection($dsn, $driverClass = 'com.mysql.jdbc.Driver')
    {
        if (!is_string($dsn) || trim($dsn) == '') {
            throw new Exception\InvalidArgumentException(__METHOD__ . " DSN param must be a valid (on-empty) string");
        }
        
        $class = Pjb::getJavaClass("java.lang.Class");
        try {
            $class->forName($driverClass);
            
        } catch (\Exception $e) {
            // Here testing class not found error
            $message = "Class not found '$driverClass' exception";
            throw new Exception\ClassNotFoundException($message, $code=null, $e);
        }
        
        try {
            $conn = $this->getDriverManager()->getConnection($dsn);
            
        } catch (Exception\JavaExceptionInterface $e) {
            var_dump(get_class($e));
            $message = $e->getCause();
            $message = (string) $e;
            var_dump($message);
            die();
            
        } catch (\Exception $e) {
            var_dump(($e instanceof Exception\JavaExceptionInterface));
            var_dump(get_class($e));
            $message = $e->getMessage();
            echo $message;
            die();
            var_dump($e->__toString());
            die();
        }
        return $conn;
    }
    

    /**
     * Return underlying java driver manager
     *
     * @return Java(java.sql.DriverManager)
     */
    public function getDriverManager()
    {
        if ($this->driverManager === null) {
            $this->driverManager = Pjb::getJavaClass('java.sql.DriverManager');
        }
        return $this->driverManager;
    }
}
