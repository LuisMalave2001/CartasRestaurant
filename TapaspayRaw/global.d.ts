import GSortable from "sortablejs";
import { GSortableEvent } from "sortablejs";

//import { SortableEvent as GSortableEvent } from "sortablejs";

declare global {
    const Sortable = GSortable;
    type SortableEvent = GSortableEvent;
}

export {};