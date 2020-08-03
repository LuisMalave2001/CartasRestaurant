/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/settings/kanban_behaviour.js":
/*!***************************************************!*\
  !*** ./resources/js/settings/kanban_behaviour.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

var globalSortableSettings = {
  handle: ".handle",
  animation: 150,
  // draggable: ".kanban-card",
  dataIdAttr: 'data-id',
  scrollSensitivity: 100,
  forceFallback: true,
  ghostClass: 'dragged-ghost'
};
$(document).ready(function () {
  "use strinct";

  setUpModalForm();
  var generalSettings = {
    // "handle": ".handle",
    "animation": 150,
    "draggable": ".draggable-testing",
    "dataIdAttr": 'data-id',
    "scrollSensitivity": 100,
    forceFallback: true
  };
  $("table tbody").each(function (index, draggable) {
    var sortable = Sortable.create(draggable, _objectSpread({
      "group": {
        "name": "cartas",
        "pull": false
      }
    }, generalSettings));
  });
  setUpProductTableEvents();
  setUpMenuTableEvents();
  setUpCarteMenuTableEvents();
});

function setUpModalForm() {
  var $formModal = $('#create-or-edit-modal');
  var $sumbitButton = $formModal.find('.modal-submit-button');
  $sumbitButton.on('click', function (event) {
    $form = $formModal.find('.modal-form form');

    if ($form.find("button.btn-submit").length > 0) {
      $form.find("button.btn-submit").click();
    } else {
      $form.submit();
    }
  });
}

function _setModalMode(buttonText) {
  var $createModal = $('#create-or-edit-modal');
  var $sumbitButton = $createModal.find('.modal-submit-button');
  $sumbitButton.text(buttonText);
}

function setModalFormCreateMode() {
  _setModalMode("Create");
}

function setModalFormEditMode() {
  _setModalMode("Save");
}

function _showModal(args) {
  if (args.constructor != Object) {
    throw "You need to pass an argument";
  }

  if (!args.modal) {
    throw "You need to pass an modal object";
  }

  if (args.onShow) {
    args.onShow();
  }

  args.title = args.title || '';
  $(args.modal).find('.modal-title').text(args.title);
  $(args.modal).modal();
}

function _appendFormToModal(modal, formElement) {
  // We do this to avoid complex validations scripts
  var submitButton = document.createElement("button");
  submitButton.type = "submit";
  submitButton.classList.add("btn-submit");
  $(submitButton).hide();
  formElement.appendChild(submitButton);
  $(formElement).on("submit", function (event) {
    $('#loader').show();
  });
  $(modal).find('.modal-form').html(formElement);
}

function changeFormMethod(params) {
  if (params.constructor != Object) {
    throw "Parameter needs to be a object!";
  }

  if (!params.form || !params.method) {
    throw "Form and Method should be passed in the object!";
  }

  var methodInput = document.createElement("input");
  methodInput.type = "hidden";
  methodInput.name = "_method";
  methodInput.value = params.method;
  params.form.appendChild(methodInput);
}

function setUpProductTableEvents() {
  $('#products tbody').sortable(_objectSpread({
    group: {
      name: "products",
      pull: "clone",
      put: false
    },
    sort: false,
    onMove: function onMove(
    /**Event*/
    evt,
    /**Event*/
    originalEvent) {
      // Example: https://jsbin.com/nawahef/edit?js,output
      evt.dragged; // dragged HTMLElement

      evt.draggedRect; // DOMRect {left, top, right, bottom}

      evt.related; // HTMLElement on which have guided

      evt.relatedRect; // DOMRect

      evt.willInsertAfter; // Boolean that is true if Sortable will insert drag element after target by default

      originalEvent.clientY; // mouse position

      $(evt.dragged).find("td:gt(1)").remove();
      $ghostEl = $(evt.dragged);
      $ghostEl.find("td:gt(1)").remove();
      $ghostEl.removeClass().addClass("d-flex");
      $ghostEl.find('td.handle').removeClass().addClass("col-1");
      $ghostEl.find('td.product-name').removeClass().addClass("col-11"); // return false; — for cancel
      // return -1; — insert before target
      // return 1; — insert after target
    },
    onClone: function onClone(
    /**Event*/
    evt) {
      var origEl = evt.item;
      var cloneEl = evt.clone; // $(cloneEl).find("td:gt(1)").remove();
      // console.log(origEl, cloneEl);
    }
  }, globalSortableSettings));
  var createModal = document.getElementById('create-or-edit-modal');
  $('#btn-add-product').on('click', function (event) {
    return _showModal({
      modal: createModal,
      title: 'Create new product',
      onShow: function onShow() {
        setModalFormCreateMode();
        var productForm = document.getElementById('product-form').cloneNode(true);
        productForm.id = "";

        _appendFormToModal(createModal, productForm);
      }
    });
  }); // Edit buttons

  $('.btn-edit-product').on("click", function (event) {
    var $editButton = $(event.currentTarget);
    var $productRow = $editButton.parents("tr:eq(0)");

    _showModal({
      modal: createModal,
      title: 'Edit product',
      onShow: function onShow() {
        setModalFormEditMode();
        var productForm = document.getElementById('product-form').cloneNode(true);
        productForm.id = "";
        changeFormMethod({
          form: productForm,
          method: "PUT"
        });
        var productName = $productRow.find(".product-name").text();
        var productPrice = $productRow.find(".product-price").text();
        productForm.querySelector(".form-product-name").value = productName;
        productForm.querySelector(".form-product-price").value = productPrice;
        productForm.action += "/" + $productRow.data("id");

        _appendFormToModal(createModal, productForm);
      }
    });
  }); // Remove buttons

  $('.btn-remove-product').on("click", function (event) {
    var $editButton = $(event.currentTarget);
    var $productRow = $editButton.parents("tr:eq(0)");
    $('#loader').show();
    $.ajax({
      url: '/product/' + $productRow.data("id"),
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      method: 'DELETE',
      success: function success(data) {
        location.reload();
      },
      error: function error() {
        $('#loader').hide();
      }
    });
  });
}

function setUpMenuTableEvents() {
  var createModal = document.getElementById('create-or-edit-modal');
  $('#btn-add-menu').on('click', function (event) {
    return _showModal({
      modal: createModal,
      title: 'Create new menu',
      onShow: function onShow() {
        setModalFormCreateMode();
        var menuForm = document.getElementById('menu-form').cloneNode(true);
        menuForm.id = "";

        _appendFormToModal(createModal, menuForm);
      }
    });
  }); // Edit buttons

  $('.btn-edit-menu').on("click", function (event) {
    var $editButton = $(event.currentTarget);
    var $menuRow = $editButton.parents("tr:eq(0)");

    _showModal({
      modal: createModal,
      title: 'Edit menu',
      onShow: function onShow() {
        setModalFormEditMode();
        var menuForm = document.getElementById('menu-form').cloneNode(true);
        menuForm.id = "";
        changeFormMethod({
          form: menuForm,
          method: "PUT"
        });
        var menuName = $menuRow.find(".menu-name").text();
        var menuPrice = $menuRow.find(".menu-price").text();
        menuForm.querySelector(".form-menu-name").value = menuName;
        menuForm.querySelector(".form-menu-price").value = menuPrice;
        menuForm.action += "/" + $menuRow.data("id");

        _appendFormToModal(createModal, menuForm);
      }
    });
  }); // Remove buttons

  $('.btn-remove-menu').on("click", function (event) {
    var $editButton = $(event.currentTarget);
    var $menuRow = $editButton.parents("tr:eq(0)");
    $('#loader').show();
    $.ajax({
      url: '/menu/' + $menuRow.data("id"),
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      method: 'DELETE',
      success: function success(data) {
        location.reload();
      },
      error: function error() {
        $('#loader').hide();
      }
    });
  });
}

function setUpCarteMenuTableEvents() {
  var createModal = document.getElementById('create-or-edit-modal');
  $('#btn-add-carte-menu').on('click', function (event) {
    return _showModal({
      modal: createModal,
      title: 'Create new carte menu',
      onShow: function onShow() {
        setModalFormCreateMode();
        var carteMenuForm = document.getElementById('carte-menu-form').cloneNode(true);
        carteMenuForm.id = "";

        _appendFormToModal(createModal, carteMenuForm);
      }
    });
  }); // Edit buttons

  $('.btn-edit-carte-menu').on("click", function (event) {
    var $editButton = $(event.currentTarget);
    var $carteMenuRow = $editButton.parents("tr:eq(0)");

    _showModal({
      modal: createModal,
      title: 'Edit carte menu',
      onShow: function onShow() {
        setModalFormEditMode();
        var carteMenuForm = document.getElementById('carte-menu-form').cloneNode(true);
        carteMenuForm.id = "";
        changeFormMethod({
          form: carteMenuForm,
          method: "PUT"
        });
        var menuName = $carteMenuRow.find(".carte-menu-name").text();
        carteMenuForm.querySelector(".form-carte-menu-name").value = menuName;
        carteMenuForm.action += "/" + $carteMenuRow.data("id");

        _appendFormToModal(createModal, carteMenuForm);
      }
    });
  }); // Remove buttons

  $('.btn-remove-carte-menu').on("click", function (event) {
    var $editButton = $(event.currentTarget);
    var $carteMenuRow = $editButton.parents("tr:eq(0)");
    $('#loader').show();
    $.ajax({
      url: '/carte-menu/' + $carteMenuRow.data("id"),
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      method: 'DELETE',
      success: function success(data) {
        location.reload();
      },
      error: function error() {
        $('#loader').hide();
      }
    });
  }); // Sortable products

  $('#menus tr[data-id=3].menu-product-list tbody').sortable(_objectSpread({
    group: {
      put: function put(to, from, dragEl, evt) {
        if (to.el.querySelector('tr[data-id="' + dragEl.dataset.id + '"]')) {
          return false;
        }

        return "products";
      }
    },
    onAdd: function onAdd(event) {
      $(event.item).find("td:gt(1)").remove();
      console.log("hola");
    }
  }, globalSortableSettings));
}

/***/ }),

/***/ 1:
/*!*********************************************************!*\
  !*** multi ./resources/js/settings/kanban_behaviour.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\LaravelTest\blog\resources\js\settings\kanban_behaviour.js */"./resources/js/settings/kanban_behaviour.js");


/***/ })

/******/ });