<?php

$root = $_SERVER["DOCUMENT_ROOT"];
define('DS', '/');

?>
<!DOCTYPE html>
<html>

<head>
    <title>Homepage</title>
    <meta charset="utf-8" />
    <?php require($root . DS . 'includes/common/assets_common_css.php') ?>
</head>

<body>

    <?php require($root . DS . 'includes/templates/kanban_templates.html') ?>

    <div class="container-fluid p-0">
        <?php require($root . DS . 'includes/common/header.php') ?>
        <main class="col-12">

            <div class="row justify-content-around mt-4">

                <!-- Cartas -->
                <div class="col-xs-12 col-md-3 kanban-column" id="cartas">
                    <div class="text-center p-1 h3 border-bottom">Cartas</div>
                    <section class="bg-light p-2 kanban-draggable-section">
                        <article class="kanban-card-add kanban-card-carta-add mb-2">
                            <div class="text-center">Add Element...</div>
                        </article>
                    </section>
                </div>

                <!-- Menus -->
                <div class="col-xs-12 col-md-3 kanban-column" id="menus">
                    <div class="text-center p-1 h3 border-bottom">Menus</div>
                    <section class="p-2 kanban-draggable-section">
                        <article class="kanban-card-add kanban-card-menu-add mb-2">
                            <div class="text-center">Add Element...</div>
                        </article>
                        
                    </section>
                </div>

                <!-- Productos -->
                <div class="col-xs-12 col-md-3 kanban-column" id="productos">
                    <div class="text-center p-1 h3 border-bottom">Productos</div>
                    <section class="bg-light p-2 kanban-draggable-section">
                        <article class="kanban-card-add kanban-card-producto-add" id="button-product-add">
                            <div class="text-center">Add Element...</div>
                        </article>
                    </section>
                </div>

            </div>

        </main>
    </div>

    <?php require($root . DS . 'includes/common/assets_common_js.php') ?>
</body>

</html>