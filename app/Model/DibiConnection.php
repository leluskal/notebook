<?php
declare(strict_types=1);

namespace App\Model;

use Dibi\Connection;

class DibiConnection
{
    /**
     * @var string
     */
    private $driver;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $databaseName;

    public function __construct(string $driver, string $host, string $username, string $password, string $databaseName)
    {
        $this->driver = $driver;
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->databaseName = $databaseName;
    }

    public function getConnection(): Connection
    {
        return new Connection([
            'driver' => $this->driver,
            'host' => $this->host,
            'username' => $this->username,
            'password' => $this->password,
            'database' => $this->databaseName
        ]);
    }
}