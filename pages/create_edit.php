<?php

require_once(__DIR__ . "/../DB.php");

$db = new DB();

$edit_mode = false;

if (isset($_GET['id'])) {
    $edit_mode = true;
    $project = $db->handler->prepare("
            SELECT projects.*,owners.id as owner_id, owners.name, owners.email, statuses.id as status_id, statuses.name as status_name FROM projects
            JOIN project_owner_pivot on projects.id = project_owner_pivot.project_id
            JOIN owners on project_owner_pivot.owner_id = owners.id
            JOIN project_status_pivot on projects.id = project_status_pivot.project_id
            JOIN statuses on project_status_pivot.status_id = statuses.id
            WHERE projects.id = :id
            LIMIT 1;
        ");
    $project->execute([":id" => $_GET['id']]);
    $project = $project->fetch(PDO::FETCH_ASSOC);
}

$owners = $db->handler->query("
    SELECT * from owners;
", PDO::FETCH_ASSOC);

$statuses = $db->handler->query("
    SELECT * from statuses;
", PDO::FETCH_ASSOC);


if (isset($_POST) && !empty($_POST) && $_POST['project_owner'] !== '') {

    $projectOwner = $db->handler->prepare("
            SELECT * from owners
            WHERE email = :email
            LIMIT 1;
        ");
    $projectOwner->execute([':email' => $_POST['project_email']]);
    $projectOwner = $projectOwner->fetch(PDO::FETCH_ASSOC);

    $owner_id = $projectOwner['id'] ?? 0;

    if (empty($projectOwner)) {
        $projectOwner = $db->handler->prepare("
                INSERT INTO owners (name, email)
                VALUES (:name, :email);
            ");
        $projectOwner->execute(['name' => $_POST['project_owner'], ':email' => $_POST['project_email']]);
        $new_owner_id = $db->handler->lastInsertId();
        $owner_id = $new_owner_id;
    }

    if ($_POST['project_id'] !== '') {
        $updateProject = $db->handler->prepare("
            UPDATE projects 
            SET title = :title, description = :description
            where id = :id;
        ");
        $updateProject->execute([':title' => $_POST['project_title'], ':description' => $_POST['project_description'], ':id' => $_POST['project_id']]);

        $updateStatus = $db->handler->prepare("
            UPDATE project_status_pivot 
            SET status_id = :status_id
            where project_id = :id;
        ");
        $updateStatus->execute([':status_id' => $_POST['project_status'], ':id' => $_POST['project_id']]);

        $updateOwner = $db->handler->prepare("
            UPDATE project_owner_pivot 
            SET owner_id = :owner_id
            where project_id = :id;
        ");
        $updateOwner->execute([':owner_id' => $owner_id, ':id' => $_POST['project_id']]);
    } else {

        $insertProject = $db->handler->prepare("
            INSERT INTO projects (title, description)
            VALUES (:title, :description);
        ");
        $insertProject->execute([":title" => $_POST['project_title'], ":description" => $_POST['project_description']]);
        $project_id = $db->handler->lastInsertId();

        $insertProjectOwnerPivot = $db->handler->prepare("
            INSERT INTO project_owner_pivot (project_id, owner_id)
            VALUES (:project_id, :owner_id);
        ");
        $insertProjectOwnerPivot->execute([':project_id' => $project_id, ':owner_id' => $owner_id]);

        $insertProjectStatusPivot = $db->handler->prepare("
            INSERT INTO project_status_pivot (project_id, status_id)
            VALUES (:project_id, :status_id);
        ");
        $insertProjectStatusPivot->execute([':project_id' => $project_id, ':status_id' => $_POST['project_status']]);
    }

    $success_save = true;
}

?>

<div class="container">

    <?php if (isset($success_save)) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Sikeres mentés!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>
    <form action="/create_edit" method="post">
        <div class="mb-3">
            <label for="project_title" class="form-label">Cím</label>
            <input type="text" class="form-control" id="project_title" name="project_title" value="<?php echo $project['title'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label for="project_description" class="form-label">Leírás</label>
            <textarea class="form-control" id="project_description" name="project_description" rows="3"><?php echo $project['description'] ?? '' ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label" for="project_status">Státusz</label>
            <select class="form-select" id="project_status" name="project_status">
                <?php foreach ($statuses as $status) : ?>
                    <option value="<?= $status['id'] ?>" <?php if ($edit_mode && $status['id'] == $project['status_id']) echo 'selected'; ?>>
                        <?= $status['name'] ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="project_owner" class="form-label">Kapcsolattartó neve</label>
            <input type="text" class="form-control" id="project_owner" name="project_owner" value="<?php echo $project['name'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label for="project_email" class="form-label">Kapcsolattartó e-mail címe</label>
            <input type="email" class="form-control" id="project_email" name="project_email" value="<?php echo $project['email'] ?? '' ?>">
        </div>
        <input type="hidden" value="<?php echo $project['id'] ?? '' ?>" name="project_id">
        <button type="submit" class="btn btn-primary">Mentés</button>
    </form>

</div>