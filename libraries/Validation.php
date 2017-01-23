<?php

 class Validation extends Database {

     public function isExists($table, $col, $row, $id = null, $row_id = 'id')
     {
         // connect to database
         $this->connect();

         $bind = [];
         $sql = "SELECT * FROM %s WHERE %s = :row";
         $bind[':row'] = $row;

         // ignore the row with the id
         if ( ! is_null($id))
         {
             $sql .= " AND ". $row_id ." = :id";
             $bind[':id'] = $id;
         }

         $sth = $this->dbh->prepare(sprintf($sql, $table, $col));
         $sth->execute($bind);
         
         return $sth->rowCount() > 0 ? true : false;
     }

 }
