<?php
abstract class DAO
{
    /**
     * Database connection
     */
    private $db;

    /**
     * Constructor
     */
    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Grants access to the database connection object
     */
    protected function getDb() {
        return $this->db;
    }

    /**
     * Builds a domain object from a DB row.
     * Must be overridden by child classes.
     */
    protected abstract function buildDomainObject($row);
}
