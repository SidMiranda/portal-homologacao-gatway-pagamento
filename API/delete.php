<?php
require('config.php');


$method = strtolower($_SERVER['REQUEST_METHOD']); 

if($method === 'delete'){

    parse_str(file_get_contents('php://input'), $input);
   
    $id = $input['id'] ?? null;

    $id = filter_var($id);

    if($id){
        $sql = $pdo->prepare("SELECT * FROM pedidos WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0 ){

            $sql = $pdo->prepare("DELETE FROM pedidos WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->execute();

        }else{
            $array['error'] = 'ID inexistente';
        }
    }else{
        $array['error'] = "id não enviados";
    }

}else{
    $array['error'] = 'Método não permitido (apenas DELETE)';
}

include('return.php');