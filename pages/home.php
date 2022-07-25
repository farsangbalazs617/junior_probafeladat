<?php

    require_once(__DIR__ . "/../DB.php");

    $db = new DB();

    $db->connect();

    $projects = $db->handler->query("select * from projects");

    print_r($projects->fetchAll());

?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3>Cím</h3>
                    <p>
                        Test Owner (test.owner@test.io)
                    </p>
                    <a href="create_edit" class="btn btn-primary">Szerkeztés</a>
                    <button class="btn btn-danger">Törlés</button>
                </div>
            </div>
        </div>
    </div>
</div>