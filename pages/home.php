<?php

require_once(__DIR__ . "/../DB.php");

$db = new DB();

$projects = $db->handler->query("
        SELECT projects.*, owners.name, owners.email, statuses.name as status_name FROM projects
        JOIN project_owner_pivot on projects.id = project_owner_pivot.project_id
        JOIN owners on project_owner_pivot.owner_id = owners.id
        JOIN project_status_pivot on projects.id = project_status_pivot.project_id
        JOIN statuses on project_status_pivot.status_id = statuses.id;
    ");

$projects = $projects->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container">
    <div class="row">
        <?php if (empty($projects)) : ?>
            <h1 class="text-center">Nincs projekt a listában kérjük vegyen <a href="create_edit">fel<a></h1>
        <?php endif ?>
        <div class="list-group">
            <?php foreach ($projects as $project) : ?>
                <div class="list-group-item p-3" id="project-<?= $project['id'] ?>">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4><?= $project['title'] ?></h4>
                        <p><?= $project['status_name'] ?></p>
                    </div>
                    <p class="mb-4"><?= $project['name'] ?> ( <?= $project['email'] ?> )</p>
                    <a href="create_edit?id=<?= $project['id'] ?>" class="btn btn-primary">Szerkeztés</a>
                    <button class="btn btn-danger" onclick="deleteProject(<?= $project['id'] ?>)">Törlés</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>