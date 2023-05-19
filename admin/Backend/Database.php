<?php


class Database extends PDO
{

    public function __construct($type, $host, $databaseName, $username, $password)
    {
        parent::__construct($type . ':host=' . $host . ';dbname=' . $databaseName . ';charset=utf8mb4', $username, $password);
        $this->exec('SET CHARACTER SET utf8mb4');
    }

    public function select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    {
        $sth = $this->prepare($sql);

        foreach ($array as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        $sth->execute();

        return $sth->fetchAll($fetchMode);
    }

    public function insert($table, array $data)
    {
        ksort($data);

        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));

        $sth = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        $sth->execute();
    }


    public function update($table, $data, $where, $whereBindArray = array())
    {
        ksort($data);

        $fieldDetails = null;

        foreach ($data as $key => $value) {
            $fieldDetails .= "`$key`=:$key,";
        }

        $fieldDetails = rtrim($fieldDetails, ',');

        $sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        foreach ($whereBindArray as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        $sth->execute();
    }

    public function delete($table, $where, $bind = array(), $limit = null)
    {
        $query = "DELETE FROM $table WHERE $where";

        if ($limit) {
            $query .= " LIMIT $limit";
        }

        $sth = $this->prepare($query);

        foreach ($bind as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        $sth->execute();
    }
}
