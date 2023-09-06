<?php  

namespace Core\Model;

abstract class Model
{
    public int $id; 

    public function __construct(array $data_row = []) 
    {
        //si on a des données, on les injecte dans l'objet
        foreach ($data_row as $column => $value) {
            //si la propriete n'existe pas, on passe à la suivante
            if(!property_exists($this, $column)) continue;
            //on injecte la valeur dans la propriete
            $this->$column = $value; 
        }
    }
}