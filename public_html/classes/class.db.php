<?php
/**
 * This class is used to access a MySQL database
 *
 * @package Huy's
 * @author  Huy
 */

class MySQLIDatabase
{
    private static $uniqueInstance;
    /**
     * The database connection
     *
     * @var resource
     */
    protected $connection;

    /**
     * An instance of the MySQLDbSettings class
     *
     * @var object
     */
    protected $settings;

    protected $show_errors = true;

    /**
     * When the class is instantiated a connection is made
     *
     * @return void
     */
    private function __construct()
    {
        $this->Connect();
    }

    public function error()
    {
        return $l['mysqli_error'];
    }

    public static function GetInstance()
    {
        if (self::$uniqueInstance == null) {
            self::$uniqueInstance = new MySQLIDatabase();
        }
        return self::$uniqueInstance;
    }

    /**
     * Create the connection to the database
     *
     * @return void
     */
    public function Connect()
    {
        $result = false;
        if (!self::$uniqueInstance->connection) {
            $this->connection = mysqli_connect(APP_DB_HOST, APP_DB_USER, APP_DB_PASSWORD, APP_DB_NAME);
            mysqli_set_charset($this->connection, "utf8");
            if ($this->connection) {
                $result = $this->connection;
            } else {
                die(mysqli_connect_error());
            }
        } else {
            $result = self::$uniqueInstance->connection;
        }
        return $result;
    }

    /**
     * This closes a database connection
     *
     * @return void
     */
    public function Close()
    {
        mysqli_close(self::$uniqueInstance->connection);
    }

    /**
     * This method creates a new record
     *
     * @param $table: (Required) the table to use
     * @param $values: (Required) an array of the values to save e.g. array('column'=>value)
     *
     * @return int
     */
    public function Create($table, $values)
    {
        $columns = $this->CommaSeparate(array_keys($values));
        $data    = $this->CommaSeparateWithQuotes(array_values($values));

        $insertQuery = "INSERT INTO $table ( $columns ) VALUES ( $data )";
        $ins         = mysqli_query(self::$uniqueInstance->connection, $insertQuery);
        if ($ins) {
            return mysqli_insert_id(self::$uniqueInstance->connection);
        } else {
            if ($this->show_errors) {
                die($this->error() . ' Query:' . $insertQuery);
            }

        }
        return 0;
    }

    /**
     * This method updates a record
     *
     * @param $table: (Required) the table to use
     * param $where: (Required) the where part of the query e.g. array('column'=>value)
     * @param $values: (Required) an array of the values to save e.g. array('column'=>value)
     *
     * @return int
     */
    public function Update($table, $where, $values)
    {
        $where  = $this->ColumnValueString($where, 'AND');
        $values = $this->ColumnValueString($values, ',');

        $update = "UPDATE $table SET $values WHERE $where";
        $u      = mysqli_query(self::$uniqueInstance->connection, $update);
        if ($u) {
            return mysqli_affected_rows(self::$uniqueInstance->connection);
        } else {
            if ($this->show_errors) {
                die(mysqli_error(self::$uniqueInstance->connection));
            }

        }
        return 0;
    }

    /**
     * This method deletes records
     *
     * @param $table: (Required) the table to use
     * param $where: (Required) the where part of the query e.g. array('column'=>value)
     *
     * @return int
     */
    public function Delete($table, $where)
    {
        $where = $this->ColumnValueString($where, 'AND');

        $delete = "DELETE FROM $table WHERE $where";

        $del = mysqli_query(self::$uniqueInstance->connection, $delete);
        if ($del) {
            return mysqli_affected_rows(self::$uniqueInstance->connection);
        } else {
            if ($this->show_errors) {
                die($this->error());
            }

        }
        return 0;
    }

    /**
     * This function performs a query on the table that represents the model
     * It then return an array of objects or an array depending on the type of query performed.
     * Except for $table other parameter can be either an array or a string
     * When the parameter that is provided is a strng, it must not include the SQL keyword
     * For example, if $where is a string,
     * it will be like "col1 = value, col2 = value" and NOT "WHERE col1 = value, col2 = value"
     *
     * @param $table: (Required) The table to query
     * @param $select: (Required) This could be a string or an array of the columns to be selected
     * @param $where: (Optional) This is for the WHERE part of a query could be a string or an array
     *                             e.g. array('column'=>value)
     * @param $grouping: (Optional) This is for the GROUP BY part of the query and is a string
     * @param $having: (Optional) This is for the having part of the query and is a string
     * @param $sort: (Optional) This is for the ORDER BY part of the query. It can be a string or
     *                             an array e.g. array('column'=>'ASC')
     * @param $limit: (Optional) This is for the LIMIT part of the query. It can be a string or
     *                             an array e.g. array('offset'=>0,'rows'=>30)
     *
     * @return array
     */
    public function Query($table, $select = null, $where = null, $grouping = null, $having = null, $sort = null, $limit = null)
    {
        $results = array();

        //Prepare the select part
        if (is_array($select)) {
            $select = $this->CommaSeparate($select);
        }

        $selectQuery = "SELECT $select FROM " . $table;

        //Prepare the where part
        if ($where != null) {
            if (is_array($where)) {
                $where = $this->ColumnValueString($where, 'AND');
            }
            $selectQuery .= " WHERE $where";
        }

        //Prepare the grouping part
        if ($grouping != null) {
            $selectQuery .= " GROUP BY $grouping";
        }

        //Prepare the having part
        if ($having != null) {
            $selectQuery .= " HAVING $having";
        }

        //Prepare the Order by part
        if ($sort != null) {
            if (is_array($sort)) {
                $sorttemp = '';
                foreach ($sort as $k => $v) {
                    $sorttemp .= "$k $v,";
                }
                $sort = substr($sorttemp, 0, -1);
            }
            $selectQuery .= " ORDER BY $sort";
        }

        //Prepare the limit part
        if ($limit != null) {
            if (is_array($limit)) {
                $limit = (int) $limit['offset'] . ", " . (int) $limit['rows'];
            }
            $selectQuery .= " LIMIT $limit";
        }
        $query = mysqli_query(self::$uniqueInstance->connection, $selectQuery);
        if ($query) {
            $numResults = mysqli_num_rows($query);
            for ($i = 0; $i < $numResults; $i++) {
                $row       = mysqli_fetch_assoc($query);
                $results[] = $row;
            }
        } else {
            if ($this->show_errors)
            // show query $selectQuery;
            {
                echo $selectQuery;
            }

            die(mysqli_error(self::$uniqueInstance->connection));
        }
        return $results;
    }

    public function rawQuery($raw)
    {
        if (!$raw) {
            return;
        }

        $query = mysqli_query(self::$uniqueInstance->connection, $raw);
        if ($query) {
            $numResults = mysqli_num_rows($query);
            for ($i = 0; $i < $numResults; $i++) {
                $row       = mysqli_fetch_assoc($query);
                $results[] = $row;
            }
        } else {
            if ($this->show_errors)
            // show query $selectQuery;
            {
                echo $selectQuery;
            }

            die($this->error());
        }
        return $results;
    }

    /**
     * This function performs a query on the MySQL database
     *
     * @param $q: (Required) Query
     *
     * @return resource
     */
    public function DirectQuery($q)
    {
        $query = mysqli_query(self::$uniqueInstance->connection, $q);
        if (!$query) {
            if ($this->show_errors) {
                die($this->error());
            }

        }
        return $query;
    }

    /**
     * This method takes an array and then turns it into a string
     * separating them with commas
     *
     * @param $k: (Required)
     *
     * @return string
     */
    protected function CommaSeparate($k)
    {
        for ($i = 0; $i < count($k); $i++) {
            $k[$i] = $k[$i];
        }
        return implode(', ', $k);
    }

    /**
     * This method takes an array and then turns it into a string
     * separating them with commas. This one adds quoates to the string values
     *
     * @param $v: (Required)
     *
     * @return string
     */
    protected function CommaSeparateWithQuotes($v)
    {
        for ($i = 0; $i < count($v); $i++) {
            if (is_numeric($v[$i])) {
                $v[$i] = $v[$i];
            } else {
                $v[$i] = "'" . $v[$i] . "'";
            }
        }

        return implode(', ', $v);
    }

    /**
     * This method takes an array and then turns it into a string
     * separating them with commas or AND
     *
     * @param $where: (Required) array to turn into a string e.g. array('column'=>value, column2'=>value)
     * @param $separator: (Required)
     *
     * @return string
     */
    protected function ColumnValueString($where, $separator)
    {
        $separator = " $separator ";
        $return    = '';
        foreach ($where as $k => $v) {
            $k = str_replace(array('\'', '\"'), '', $k);
            $v = str_replace(array('\'', '\"'), '', $v);
            $return .= addslashes($k) . " = ";
            if (is_numeric($v)) {
                $return .= $v;
            } else {
                $return .= "'" . $v . "'";
            }
            $return .= $separator;
        }

        return substr($return, 0, -strlen($separator));
    }
//         function __destruct() {
    //             $this->Close();
    //         }
}
