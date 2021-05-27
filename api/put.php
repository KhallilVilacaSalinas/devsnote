<?php
require('../config.php');
//error_reporting(E_ERROR);

$method = strtolower($_SERVER['REQUEST_METHOD']);

if ($method === 'put') {

    // $input = [];
    parse_str(file_get_contents('php://input'), $input);
    // print_r($input);

    $id = $input['id'] ?? null;
    $title = $input['title'] ?? null;
    $body = $input['body'] ?? null;

    // echo $id;
    // echo $title;
    // echo $body;
    // die("Ola");

    $id = filter_var($id);
    $title = filter_var($title);
    $body = filter_var($body);

    if ($id && $title && $body) {
        $sql = $pdo->prepare("SELECT * FROM note WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {

            $sql = $pdo->prepare("UPDATE notes SET title = :title, body = :body WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->bindValue(':title', $title);
            $sql->bindValue(':body', $body);
            $sql->execute();

            $array['result'] = [
                'id' => $id,
                'title' => $title,
                'body' => $body
            ];
        } else {
            $array['error'] = "ID inexistente";
        }
    } else {
        $array['error'] = "Dados nao enviados";
    }
} else {
    $array['error'] = 'Método não permitido (apenas )';
}
require('../return.php');
