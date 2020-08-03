"use strict";
//import { MoveEvent } from "sortablejs";
var __assign = (this && this.__assign) || function () {
    __assign = Object.assign || function(t) {
        for (var s, i = 1, n = arguments.length; i < n; i++) {
            s = arguments[i];
            for (var p in s) if (Object.prototype.hasOwnProperty.call(s, p))
                t[p] = s[p];
        }
        return t;
    };
    return __assign.apply(this, arguments);
};
(function () {
    "use strict";
    function removeSortableItem() {
        var item = $(this).parents(".kanban-card")[0];
        item.remove();
    }
    function renderKanbanTemplate(templateId, options) {
        var kanbanElementTemplate = document.querySelector("#templates #" + templateId);
        if (kanbanElementTemplate) {
            var newSortableElement = kanbanElementTemplate.cloneNode(true);
            // We need to remove the id to keep the DOM properly formatted
            var id = 0;
            if (options) {
                if (options.hasOwnProperty("id") && options.id) {
                    id = options.id;
                }
            }
            newSortableElement.id = "";
            newSortableElement.dataset["kanbanId"] = templateId + '-' + id;
            newSortableElement.dataset["serverId"] = '' + id;
            return newSortableElement;
        }
        return undefined;
    }
    function loadEventHandlersToKanbanItem(kanbanItem) {
        if (kanbanItem) {
            var removeButton = kanbanItem.querySelector(".kanban-button.remove");
            if (removeButton) {
                removeButton.addEventListener("click", removeSortableItem);
            }
        }
    }
    function checkIfRepeated(event) {
        if (event.to.querySelector(".already-added[data-kanban-id='" + event.clone.dataset["kanbanId"] + "'")) {
            event.item.remove();
        }
        else {
            $(event.item).addClass("already-added");
        }
    }
    function createNewProductItem() {
        var _this = this;
        $.ajax({
            method: "POST",
            url: "/cartas/product",
            dataType: "json",
            data: {
                "name": ""
            },
            success: function (product) {
                console.log("data: ", product);
                var productoItem = renderKanbanTemplate("kanban-card-producto", {
                    "id": product["id"]
                });
                var $productoItem = $(productoItem);
                $productoItem.data("price", product["price"]);
                setProductItemEvents(productoItem);
                (_this.parentElement).insertBefore(productoItem, _this.nextSibling);
            }
        });
    }
    /**
     * We add all products in product list
     */
    function updateProduct(product) {
        $.ajax({
            method: "PUT",
            url: "/cartas/product/" + product.product_id,
            data: {
                name: product.name,
                price: product.price
            },
            success: function (result) {
                console.log("Updated!");
            }
        });
    }
    ;
    function setProductItemEvents(productItem) {
        var $productoItem = $(productItem);
        $productoItem.find("input[name='name']").on("change keyup", function () {
            var product = {
                name: $productoItem.find("input[name='name']").val(),
                product_id: $productoItem.data("serverId"),
                price: $productoItem.data("price"),
            };
            updateProduct(product);
        });
        $productoItem.find(".kanban-button.remove").on("click", function () {
            $.ajax({
                method: "DELETE",
                url: "/cartas/product/" + $productoItem.data("serverId"),
                success: function () {
                    $productoItem.remove();
                }
            });
        });
    }
    function showContextualMenu(event) {
        var $target = $(event.currentTarget);
        var $menu = $('#kanban-action-menu');
        // var position = $("#fixed").offset();
        var targetPosition = $target.offset();
        $(window).scroll(function () {
            var position = $("#fixed").offset();
            $("#fixed").html(position.top);
        });
        var widthOffset = $menu.width();
        var heightOffset = $menu.height();
        if (targetPosition) {
            targetPosition.left -= widthOffset || 0;
            //targetPosition.top -= heightOffset || 0;
            if ($menu.is(":hidden") && !_.isEqual(targetPosition, $menu.position())) {
                $menu.data("kanban-id", $target.data("kanban-id"));
                $menu.data("model", $target.data("model"));
                $menu.css(targetPosition);
                $menu.show();
                $menu.focus();
            }
            else {
                $menu.hide();
            }
        }
    }
    function addContextMenuEvents() {
        var $kanbanActionMenu = $("#kanban-action-menu");
        var $actionModify = $kanbanActionMenu.find(".kanban-action-modify");
        $actionModify.on("click", function (event) {
            switch ($kanbanActionMenu.data("model")) {
                case "product":
                    $kanbanActionMenu.hide();
                    var $productModel = $('#productEditionModal').modal({
                        "show": true,
                        backdrop: 'static',
                        keyboard: false
                    });
                    var kanbanId = $("#" + $kanbanActionMenu.data("kanbanId"));
                    var kanbanLabel = kanbanId.find(".label").text();
                    $('#productNameInput').val(kanbanLabel);
                    $productModel.find("#productNameInput").val();
                    break;
            }
        });
    }
    $(function () {
        addContextMenuEvents();
        var generalSettings = {
            "handle": ".handle",
            "animation": 150,
            "draggable": ".kanban-card",
            "dataIdAttr": 'data-id',
            "scrollSensitivity": 100,
            forceFallback: true,
        };
        $('article.card-producto').each(function (i, productItem) {
            setProductItemEvents(productItem);
        });
        $(".kanban-button.actions").on("click", showContextualMenu);
        //updateProductList();
        // Cartas
        $("#cartas .kanban-draggable-section").each(function (index, cartaKanbanDraggable) {
            var sortable = Sortable.create(cartaKanbanDraggable, __assign({ "group": {
                    "name": "cartas",
                    "pull": false,
                }, onClone: function (event) {
                    loadEventHandlersToKanbanItem(event.clone);
                } }, generalSettings));
        });
        // Menu kanban
        var menuKanbanDraggables = document.querySelectorAll("#menus .kanban-draggable-section");
        var makeProductListSortable = function (productSortableList) {
            Sortable.create(productSortableList, __assign({ "group": {
                    "name": "productos-menu",
                    put: ["productos"],
                }, onAdd: checkIfRepeated }, generalSettings));
        };
        menuKanbanDraggables.forEach(function (menuKanbanDraggable) {
            var sortable = Sortable.create(menuKanbanDraggable, __assign({ "group": {
                    "name": "menu",
                    "pull": "clone"
                }, onClone: function (event) {
                    var productSortableList = event.clone.querySelector(".kanban-draggable-section-product");
                    loadEventHandlersToKanbanItem(event.clone);
                    makeProductListSortable(productSortableList);
                    var productItems = productSortableList.querySelectorAll('.kanban-card');
                    if (productItems) {
                        productItems.forEach(function (productItem) {
                            loadEventHandlersToKanbanItem(productItem);
                        });
                    }
                } }, generalSettings));
        });
        //Productos kanban
        var productoKanbanDraggables = document.querySelectorAll("#productos .kanban-draggable-section");
        productoKanbanDraggables.forEach(function (productoKanbanDraggable) {
            var sortable = Sortable.create(productoKanbanDraggable, __assign({ "group": {
                    "name": "productos",
                    "pull": "clone"
                }, onClone: function (event) {
                    loadEventHandlersToKanbanItem(event.clone);
                } }, generalSettings));
        });
        $(".kanban-column .kanban-draggable-section .kanban-button.remove").on("click", removeSortableItem);
        // Add product item to product column
        $(".kanban-card-producto-add").on("click", createNewProductItem);
        // Add menu item to menu column
        $(".kanban-card-menu-add").on("click", function () {
            var menuCard = renderKanbanTemplate("kanban-card-menu");
            (this.parentElement).insertBefore(menuCard, this.nextSibling);
            var productSortableList = menuCard.querySelector(".kanban-draggable-section-product");
            Sortable.create(productSortableList, __assign({ "group": {
                    "name": "productos-menu",
                    put: ["productos"],
                }, onAdd: checkIfRepeated }, generalSettings));
        });
        // Add carta item to carta column
        $(".kanban-card-carta-add").on("click", function (event) {
            var cartaItem = renderKanbanTemplate("kanban-card-carta");
            (this.parentElement).insertBefore(cartaItem, this.nextSibling);
            var productSortableList = cartaItem.querySelector(".kanban-draggable-section-all");
            Sortable.create(productSortableList, __assign({ "group": {
                    "name": "carta-item-list",
                    "put": ["menu", "productos"]
                }, onAdd: function (event) {
                    // Cartas kanban doesn't need show the product list...
                    var productList = event.item.querySelector(".kanban-draggable-section-product");
                    if (productList) {
                        productList.remove();
                    }
                    checkIfRepeated(event);
                    console.log("event.pullMode", event.pullMode);
                } }, generalSettings));
        });
        $('#loading').fadeOut();
    });
})();
