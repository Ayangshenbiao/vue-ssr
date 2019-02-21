<?php
/**
 * @author Andy Camm
 */

// Subclass wpdb to ensure compatibility with WordPress and to use
// the appropriate MySQL module (uses MySQLi on PHP >= 5.5)
// and provide access to the additional raw MySQL/MySQLi module calls 
// that we are using
class wpc_wpdb extends wpdb
{
    
    // This is copied from the base class as its use_mysqli member is private
    protected $use_mysqli = false;
    
    public function __construct( $dbuser, $dbpassword, $dbname, $dbhost ) {
        parent::__construct($dbuser, $dbpassword, $dbname, $dbhost);

        // This is copied from the base class as its use_mysqli member is private
        // Use ext/mysqli if it exists and:
        //  - WP_USE_EXT_MYSQL is defined as false, or
        //  - We are a development version of WordPress, or
        //  - We are running PHP 5.5 or greater, or
        //  - ext/mysql is not loaded.
        //
        if ( function_exists( 'mysqli_connect' ) ) {
            if ( defined( 'WP_USE_EXT_MYSQL' ) ) {
                $this->use_mysqli = ! WP_USE_EXT_MYSQL;
            } elseif ( version_compare( phpversion(), '5.5', '>=' ) || ! function_exists( 'mysql_connect' ) ) {
                $this->use_mysqli = true;
            } elseif ( false !== strpos( $GLOBALS['wp_version'], '-' ) ) {
                $this->use_mysqli = true;
            }
        }
    }
    
    public function get_dbh()
    {
        return $this->dbh;
    }
    
    public function query($querystring)
    {
        if ($this->use_mysqli)
        {
            return $this->get_dbh()->query($querystring);
        }
        else
        {
            return mysql_query($querystring, $this->get_dbh());
        }
    }
    
    public function ping()
    {
        if ($this->use_mysqli)
        {
            return $this->get_dbh()->ping();
        }
        else
        {
            return mysql_ping($this->get_dbh());
        }
    }
    
    
    public function close()
    {
        if ($this->use_mysqli)
        {
            $this->get_dbh()->close();
        }
        else{
            return mysql_close($this->get_dbh());
        }
    }
    
    public function error()
    {
        if ($this->use_mysqli)
        {
            return $this->get_dbh()->error;
        }
        else
        {
            return mysql_error($this->get_dbh());
        }
    }
    
    public function errno()
    {
        if ($this->use_mysqli)
        {
            return $this->get_dbh()->errno;
        }
        else
        {
            return mysql_errno($this->get_dbh());
        }
    }
    

    public function real_escape_string($str)
    {
        return $this->_escape($str);
    }
    
    public function num_fields( $result)
    {
        if ($this->use_mysqli)
        {
            return $result->field_count;
        }
        else
        {
            return mysql_num_fields($result);
        }
    }
    
    public function fetch_array($result)
    {
        if ($this->use_mysqli)
        {
            return $result->fetch_array();
    
        }
        else {
            return mysql_fetch_array($result);
        }
    }
    
    // Fetch a row from a query result
    public function fetch_row( $result)
    {
        if ($this->use_mysqli)
        {
            return $result->fetch_row();
        }
        else
        {
            return mysql_fetch_row($result);
        }
    }
    
}
