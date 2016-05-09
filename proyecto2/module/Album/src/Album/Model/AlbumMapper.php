<?php
namespace Album\Model;

class AlbumMapper
{
    
    public function select()
    {
        $query = "SELECT * FROM album";
        $results = $this->execute($query);
        
        $adapterMaster->select($query);
        
        return $results;
    }
}