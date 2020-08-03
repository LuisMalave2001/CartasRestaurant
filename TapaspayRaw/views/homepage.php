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
                <!-- Productos -->
                <div class="col-12 kanban-column" id="productos">
                    <div class="text-center p-1 h3 border-bottom">Productos</div>
                    <section class="bg-light p-2 kanban-draggable-section">
                        <article class="kanban-card-add kanban-card-producto-add" id="button-product-add">
                            <div class="text-center">Add Element...</div>
                        </article>

                        <?php foreach ($product_ids as $product_id): ?>
                            <article class="kanban-card card-producto" 
                                     data-kanban-id="kanban-card-producto-<?= $product_id->id?>"
                                     data-server-id="<?= $product_id->id?>"
                                     data-price="<?= $product_id->price?>"
                                     data-model="product"
                                     id="kanban-card-producto-<?= $product_id->id?>">
                                <div class="d-flex">
                                    <div class="col-2 kanban-button handle"><i class="fa fa-arrows"></i></div>
                                    <div class="col kanban-card-name">
                                        <div class="row">
                                            <span class="col-11"><span class="label"><?= $product_id->name?></span>
                                            <!--<input type="text" name="name" class="w-100 kanban-card-label" value="">-->
                                            </span>
                                            <span class="col-1 kanban-button actions"
                                            data-kanban-id="kanban-card-producto-<?= $product_id->id?>"
                                            data-model="product"
                                             ><i class="fa fa-ellipsis-v"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach ?>

                    </section>
                </div>

                <!-- Menus -->
                <div class="col-12 kanban-column" id="menus">
                    <div class="text-center p-1 h3 border-bottom">Menus</div>
                    <section class="p-2 kanban-draggable-section">
                        <article class="kanban-card-add kanban-card-menu-add mb-2">
                            <div class="text-center">Add Element...</div>
                        </article>
                        
                    </section>
                </div>

                <!-- Cartas -->
                <div class="col-12 kanban-column" id="cartas">
                    <div class="text-center p-1 h3 border-bottom">Cartas</div>
                    <section class="bg-light p-2 kanban-draggable-section">
                        <article class="kanban-card-add kanban-card-carta-add mb-2">
                            <div class="text-center">Add Element...</div>
                        </article>
                    </section>
                </div>
            </div>
        </main>
    </div>
    
    <div class="modal fade" id="productEditionModal" tabindex="-1" role="dialog" aria-labelledby="productEditionTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productEditionTitle">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="cartas/product">
                <div class="modal-body">
                    <section>
                        <div class="form-group">
                            <label for="productNameInput" class="font-weight-bold">Product</label>
                            <input id="productNameInput" type="text" name="name" class="form-control" />
                        </div>
                    </section>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <div id="loading" class="loading">
        <img src="/static/img/svg/loading.svg"/>
    </div>

    <?php require($root . DS . 'includes/common/assets_common_js.php') ?>
</body>

</html>