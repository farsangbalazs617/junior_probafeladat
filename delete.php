<?php

//Ezt a fájlt hívja meg aszinkron módon a javascript a törléshez

require_once("DB.php");

$db = new DB();

$data = json_decode(file_get_contents("php://input"));

try {
    
    $db->handler->beginTransaction();

    $deleteProject = $db->handler->prepare("
        DELETE FROM project_owner_pivot
        WHERE project_id = :id;
    ");
    $deleteProject->execute([':id' => $data->project_id]);

    $deleteProject = $db->handler->prepare("
        DELETE FROM project_status_pivot
        WHERE project_id = :id;
    ");
    $deleteProject->execute([':id' => $data->project_id]);


    $deleteProject = $db->handler->prepare("
        DELETE FROM projects
        WHERE id = :id;
    ");
    $deleteProject->execute([':id' => $data->project_id]);

    $db->handler->commit();

} catch (Exception $e) {
    $db->handler->rollBack();
}






