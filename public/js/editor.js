/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/uploadAdapter.js":
/*!***************************************!*\
  !*** ./resources/js/uploadAdapter.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var Uploadadapter = /*#__PURE__*/function () {
  function Uploadadapter(loader) {
    _classCallCheck(this, Uploadadapter);

    this.loader = loader;
  }

  _createClass(Uploadadapter, [{
    key: "upload",
    value: function upload() {
      var _this = this;

      return this.loader.file.then(function (file) {
        return new Promise(function (resolve, reject) {
          _this._initRequest();

          _this._initListeners(resolve, reject, file);

          _this._sendRequest(file);
        });
      });
    }
  }, {
    key: "_initRequest",
    value: function _initRequest() {
      alert('request');
      console.log(document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
      console.log('test');
      var xhr = this.xhr = new XMLHttpRequest(); // xhr.open('POST', '/api/upload', true);

      xhr.open('POST', 'http://localhost:8000/api/upload', true);
      xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
      xhr.responseType = 'json';
    }
  }, {
    key: "_initListeners",
    value: function _initListeners(resolve, reject, file) {
      var xhr = this.xhr;
      var loader = this.loader;
      var genericErrorText = '파일을 업로드 할 수 없습니다.11';
      xhr.addEventListener('error', function () {
        reject(genericErrorText);
      });
      xhr.addEventListener('abort', function () {
        return reject();
      });
      xhr.addEventListener('load', function () {
        var response = xhr.response;
        console.log(xhr);

        if (!response || response.error) {
          return reject(response && response.error ? response.error.message : genericErrorText);
        }

        resolve({
          "default": response.url //업로드된 파일 주소

        });
      });
    }
  }, {
    key: "_sendRequest",
    value: function _sendRequest(file) {
      var data = new FormData();
      data.append('upload', file);
      this.xhr.send(data);
    }
  }]);

  return Uploadadapter;
}(); // module.exports = Uploadadapter


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Uploadadapter);

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!********************************!*\
  !*** ./resources/js/editor.js ***!
  \********************************/
// require("./ckeditor.js");
// import CKFinder from '@ckeditor/ckeditor5-ckfinder/src/ckfinder';
var UploadAdapter = __webpack_require__(/*! ./uploadAdapter.js */ "./resources/js/uploadAdapter.js"); // alert('editor');


ClassicEditor.create(document.querySelector('#editor'), {
  // plugins: [ MediaEmbed ],
  // builtInPlugins: [MediaEmbed],
  extraPlugins: [MyCustomUploadAdapterPlugin],
  // Enable the CKFinder button in the toolbar.
  toolbar: ["blockQuote", "bold", "imageTextAlternative", "mediaEmbed", "link", "ckfinder", "selectAll", "undo", "redo", "heading", "resizeImage:original", "resizeImage", "imageResize", "imageStyle:full", "imageStyle:side", "uploadImage", "imageUpload", "indent", "outdent", "italic", "numberedList", "bulletedList", "mediaEmbed", "insertTable", "tableColumn", "tableRow", "mergeTableCells"] // mediaEmbed: {
  //     providers: [
  //         {
  //              name: 'myProvider',
  //              url: /^example\.com\/media\/(\w+)/,
  //              html: match => '...'
  //         },
  //     ],
  //     previewsInData: true
  // },

}).then(function (editor) {
  console.log(editor); // console.log( Array.from( editor.ui.componentFactory.names() ) );
})["catch"](function (error) {
  console.error(error);
});

function MyCustomUploadAdapterPlugin(editor) {
  editor.plugins.get('FileRepository').createUploadAdapter = function (loader) {
    return new UploadAdapter(loader);
  };
}
})();

/******/ })()
;