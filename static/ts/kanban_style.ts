//import { MoveEvent } from "sortablejs";

(function(){
    "use strict";
    
    function removeSortableItem(this: any){ 
        let item = <HTMLElement>$(this).parents(".kanban-card")[0];
        item.remove();
    }

    interface renderTemplateOptions {
        id: number
    }

    function renderKanbanTemplate(templateId: string, options?: renderTemplateOptions): HTMLElement | undefined{
        let kanbanElementTemplate = <HTMLElement>document.querySelector("#templates #"+ templateId);
        
        if (kanbanElementTemplate){
            let newSortableElement = <HTMLElement>kanbanElementTemplate.cloneNode(true);
            
            // We need to remove the id to keep the DOM properly formatted
            let id: number = 0;
            if (options){
                if (options.hasOwnProperty("id") && options.id){
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

    function loadEventHandlersToKanbanItem(kanbanItem: HTMLElement){
        if (kanbanItem){
            let removeButton = kanbanItem.querySelector(".kanban-button.remove");
            if (removeButton){
                removeButton.addEventListener("click", removeSortableItem);
            }
        }
    }

    function checkIfRepeated(event: SortableEvent){

        if(event.to.querySelector(".already-added[data-kanban-id='" + event.clone.dataset["kanbanId"] + "'")){
            event.item.remove();
        }else{
            $(event.item).addClass("already-added");
        }
        
    }   

    function createNewProductItem(this: Element){
        $.ajax({
            method: "POST",
            url: "/cartas/product",
            dataType: "json",
            data: {
                "name": ""
            },
            success: (product) => {
                console.log("data: ", product);
                let productoItem = <HTMLElement>renderKanbanTemplate("kanban-card-producto", {
                    "id": product["id"]
                });
                let $productoItem = $(productoItem);
                $productoItem.data("price", product["price"])
                setProductItemEvents(productoItem);
                (this.parentElement)!.insertBefore(productoItem, this.nextSibling);
            }
        });
    }

    /**
     * We add all products in product list
     */

    function updateProduct(product: Product){
        $.ajax({
            method: "PUT",
            url: "/cartas/product/" + product.product_id,
            data: {
                name: product.name,
                price: product.price
            },
            success: (result) => {
                console.log("Updated!");
            }
        })
    };

    function setProductItemEvents(productItem: HTMLElement){
        let $productoItem = $(productItem);
        $productoItem.find("input[name='name']").on("change keyup", function(){
            let product: Product = {
                name: <string>$productoItem.find("input[name='name']").val(),
                product_id: <number>$productoItem.data("serverId"),
                price: <number>$productoItem.data("price"),
            }
            updateProduct(product);
        });

        $productoItem.find(".kanban-button.remove").on("click", function(){
            $.ajax({
                method: "DELETE",
                url: "/cartas/product/"+$productoItem.data("serverId"),
                success: function(){
                    $productoItem.remove();
                }
            })
        });
    }

    function updateProductList(){
        $.ajax({
            method: "GET",
            url: "/cartas/product",
            dataType: "json",
            success: (productList) => {
                let buttonAdd = document.getElementById("button-product-add");
                for(var product of productList){
                    let productItem = <HTMLElement>renderKanbanTemplate("kanban-card-producto", {
                        "id": product["id"]
                    });
                    
                    let $productoItem = $(productItem);
                    $productoItem.find("input[name='name']").val(product["name"]);
                    setProductItemEvents(productItem);
                    productItem.dataset["price"] =  product["price"];
                    if(buttonAdd){
                        (buttonAdd.parentElement)!.insertBefore(productItem, buttonAdd.nextSibling);
                    }
                }
            }
        });
    }

    $(function(){

        let generalSettings = {
            "handle": ".handle",
            "animation": 150,
            "draggable": ".kanban-card",
            "dataIdAttr": 'data-id',
            "scrollSensitivity": 100,
            forceFallback: true,
        }

        updateProductList();

        // Cartas
        let cartaKanbanDraggables = document.querySelectorAll("#cartas .kanban-draggable-section");
        cartaKanbanDraggables.forEach( (cartaKanbanDraggable) => {
            let sortable = Sortable.create(<HTMLElement>cartaKanbanDraggable, {
                "group": {
                    "name": "cartas",
                    "pull": false,
                },
                onClone: (event: SortableEvent) => {
                    loadEventHandlersToKanbanItem(event.clone);
                },
                ...generalSettings
            });
        } );        

        // Menu kanban
        let menuKanbanDraggables = document.querySelectorAll("#menus .kanban-draggable-section");
        
        let makeProductListSortable = (productSortableList: HTMLElement) => {
            Sortable.create(productSortableList, {
                "group": {
                    "name": "productos-menu",
                    put: ["productos"],
                },
                onAdd: checkIfRepeated,
                ...generalSettings
            });
        }
        menuKanbanDraggables.forEach((menuKanbanDraggable) => {
            let sortable = Sortable.create(<HTMLElement>menuKanbanDraggable, {
                "group": {
                    "name": "menu",
                    "pull": "clone"
                },
                onClone: (event: SortableEvent) => {
                    let productSortableList = event.clone.querySelector(".kanban-draggable-section-product");
                    loadEventHandlersToKanbanItem(event.clone);
                    makeProductListSortable(productSortableList);

                    let productItems = <NodeList>productSortableList.querySelectorAll('.kanban-card');
                    if (productItems){
                        productItems.forEach( (productItem)  => {
                            loadEventHandlersToKanbanItem(<HTMLElement>productItem);
                        });
                    }

                },
                
                //onMove:  (event: MoveEvent, originalEvent: Event) : boolean | -1 | 1 => {
                    
                //},,
                ...generalSettings
            });
        });        


        //Productos kanban
        let productoKanbanDraggables = document.querySelectorAll("#productos .kanban-draggable-section");
        productoKanbanDraggables.forEach( (productoKanbanDraggable) => {
            let sortable = Sortable.create(<HTMLElement>productoKanbanDraggable, {
                "group": {
                    "name": "productos",
                    "pull": "clone"
                },
                onClone: (event: SortableEvent) => {
                    loadEventHandlersToKanbanItem(event.clone);
                },
                ...generalSettings
            });
        } );


        $(".kanban-column .kanban-draggable-section .kanban-button.remove").on("click", removeSortableItem);
        
        // Add product item to product column
        $(".kanban-card-producto-add").on("click", createNewProductItem);

        // Add menu item to menu column
        $(".kanban-card-menu-add").on("click", function(){
            let menuCard = <HTMLElement>renderKanbanTemplate("kanban-card-menu");
            (this.parentElement)!.insertBefore(menuCard, this.nextSibling);
            let productSortableList = menuCard.querySelector(".kanban-draggable-section-product");
            Sortable.create(<HTMLElement>productSortableList, {
                "group": {
                    "name": "productos-menu",
                    put: ["productos"],
                },
                
                onAdd: checkIfRepeated,
                ...generalSettings
            });
        });

        // Add carta item to carta column
        $(".kanban-card-carta-add").on("click", function(event){
            let cartaItem = <HTMLElement>renderKanbanTemplate("kanban-card-carta");
            (this.parentElement)!.insertBefore(cartaItem, this.nextSibling);
            let productSortableList = cartaItem.querySelector(".kanban-draggable-section-all");
            Sortable.create(<HTMLElement>productSortableList, {
                "group": {
                    "name": "carta-item-list",
                    "put": ["menu", "productos"]
                },
                onAdd: (event: SortableEvent) => {
                    // Cartas kanban doesn't need show the product list...
                    let productList = event.item.querySelector(".kanban-draggable-section-product");
                    if (productList){
                        productList.remove();
                    }
                    checkIfRepeated(event);
                    console.log("event.pullMode", event.pullMode);
                },
                ...generalSettings
            });
        });

    });
    
})();