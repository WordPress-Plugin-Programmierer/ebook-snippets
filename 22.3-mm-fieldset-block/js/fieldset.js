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
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./blocks/fieldset.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./blocks/fieldset.js":
/*!****************************!*\
  !*** ./blocks/fieldset.js ***!
  \****************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("var __ = wp.i18n.__;\nvar _wp$blocks = wp.blocks,\n    registerBlockType = _wp$blocks.registerBlockType,\n    createBlock = _wp$blocks.createBlock;\nvar RichText = wp.blockEditor.RichText;\nregisterBlockType('mm/fieldset', {\n  title: 'Fieldset',\n  category: 'widgets',\n  icon: 'editor-kitchensink',\n  keywords: ['MM', 'Fieldset', 'Label'],\n  supports: {\n    multiple: true,\n    align: true,\n    className: true\n  },\n  attributes: {\n    legend: {\n      source: 'text',\n      type: 'string',\n      selector: 'legend'\n    },\n    content: {\n      source: 'html',\n      type: 'string',\n      selector: 'div.content'\n    }\n  },\n  deprecated: [{\n    attributes: {\n      legend: {\n        source: 'text',\n        type: 'string',\n        selector: 'legend'\n      },\n      content: {\n        source: 'html',\n        type: 'string',\n        selector: 'div.content'\n      }\n    },\n    save: function save(_ref) {\n      var attributes = _ref.attributes;\n      return wp.element.createElement(\"fieldset\", {\n        className: \"mm-fieldset\"\n      }, wp.element.createElement(RichText.Content, {\n        tagName: \"legend\",\n        value: attributes.legend\n      }), \" \", wp.element.createElement(RichText.Content, {\n        tagName: \"div\",\n        className: \"content\",\n        value: attributes.content\n      }));\n    }\n  }],\n  transforms: {\n    to: [{\n      type: 'block',\n      blocks: ['core/paragraph'],\n      transform: function transform(_ref2) {\n        var legend = _ref2.legend,\n            content = _ref2.content;\n        return createBlock('core/paragraph', {\n          content: legend + '<br />' + content\n        });\n      }\n    }],\n    from: [{\n      type: 'block',\n      blocks: ['core/paragraph'],\n      transform: function transform(attributes) {\n        return createBlock('mm/fieldset', {\n          content: attributes.content\n        });\n      }\n    }]\n  },\n  edit: function edit(props) {\n    var attributes = props.attributes,\n        setAttributes = props.setAttributes;\n    return wp.element.createElement(\"fieldset\", {\n      className: \"mm-fieldset\"\n    }, wp.element.createElement(RichText, {\n      tagName: \"legend\",\n      value: attributes.legend,\n      placeholder: __('Enter a label', 'mfb'),\n      multiline: false,\n      onChange: function onChange(value) {\n        setAttributes({\n          legend: value\n        });\n      }\n    }), \" \", wp.element.createElement(RichText, {\n      tagName: \"div\",\n      className: \"content\",\n      value: attributes.content,\n      placeholder: __('Enter some content', 'mfb'),\n      multiline: false,\n      onChange: function onChange(value) {\n        setAttributes({\n          content: value\n        });\n      }\n    }));\n  },\n  save: function save(props) {\n    var attributes = props.attributes;\n    return wp.element.createElement(\"div\", {\n      className: \"mm-fieldset\"\n    }, wp.element.createElement(\"fieldset\", {\n      className: \"mm-fieldset\"\n    }, wp.element.createElement(RichText.Content, {\n      tagName: \"legend\",\n      value: attributes.legend\n    }), \" \", wp.element.createElement(RichText.Content, {\n      tagName: \"div\",\n      className: \"content\",\n      value: attributes.content\n    })));\n  }\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9ibG9ja3MvZmllbGRzZXQuanMuanMiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9ibG9ja3MvZmllbGRzZXQuanM/OGQ3ZSJdLCJzb3VyY2VzQ29udGVudCI6WyJ2YXIgX18gPSB3cC5pMThuLl9fO1xudmFyIF93cCRibG9ja3MgPSB3cC5ibG9ja3MsXG4gICAgcmVnaXN0ZXJCbG9ja1R5cGUgPSBfd3AkYmxvY2tzLnJlZ2lzdGVyQmxvY2tUeXBlLFxuICAgIGNyZWF0ZUJsb2NrID0gX3dwJGJsb2Nrcy5jcmVhdGVCbG9jaztcbnZhciBSaWNoVGV4dCA9IHdwLmJsb2NrRWRpdG9yLlJpY2hUZXh0O1xucmVnaXN0ZXJCbG9ja1R5cGUoJ21tL2ZpZWxkc2V0Jywge1xuICB0aXRsZTogJ0ZpZWxkc2V0JyxcbiAgY2F0ZWdvcnk6ICd3aWRnZXRzJyxcbiAgaWNvbjogJ2VkaXRvci1raXRjaGVuc2luaycsXG4gIGtleXdvcmRzOiBbJ01NJywgJ0ZpZWxkc2V0JywgJ0xhYmVsJ10sXG4gIHN1cHBvcnRzOiB7XG4gICAgbXVsdGlwbGU6IHRydWUsXG4gICAgYWxpZ246IHRydWUsXG4gICAgY2xhc3NOYW1lOiB0cnVlXG4gIH0sXG4gIGF0dHJpYnV0ZXM6IHtcbiAgICBsZWdlbmQ6IHtcbiAgICAgIHNvdXJjZTogJ3RleHQnLFxuICAgICAgdHlwZTogJ3N0cmluZycsXG4gICAgICBzZWxlY3RvcjogJ2xlZ2VuZCdcbiAgICB9LFxuICAgIGNvbnRlbnQ6IHtcbiAgICAgIHNvdXJjZTogJ2h0bWwnLFxuICAgICAgdHlwZTogJ3N0cmluZycsXG4gICAgICBzZWxlY3RvcjogJ2Rpdi5jb250ZW50J1xuICAgIH1cbiAgfSxcbiAgZGVwcmVjYXRlZDogW3tcbiAgICBhdHRyaWJ1dGVzOiB7XG4gICAgICBsZWdlbmQ6IHtcbiAgICAgICAgc291cmNlOiAndGV4dCcsXG4gICAgICAgIHR5cGU6ICdzdHJpbmcnLFxuICAgICAgICBzZWxlY3RvcjogJ2xlZ2VuZCdcbiAgICAgIH0sXG4gICAgICBjb250ZW50OiB7XG4gICAgICAgIHNvdXJjZTogJ2h0bWwnLFxuICAgICAgICB0eXBlOiAnc3RyaW5nJyxcbiAgICAgICAgc2VsZWN0b3I6ICdkaXYuY29udGVudCdcbiAgICAgIH1cbiAgICB9LFxuICAgIHNhdmU6IGZ1bmN0aW9uIHNhdmUoX3JlZikge1xuICAgICAgdmFyIGF0dHJpYnV0ZXMgPSBfcmVmLmF0dHJpYnV0ZXM7XG4gICAgICByZXR1cm4gd3AuZWxlbWVudC5jcmVhdGVFbGVtZW50KFwiZmllbGRzZXRcIiwge1xuICAgICAgICBjbGFzc05hbWU6IFwibW0tZmllbGRzZXRcIlxuICAgICAgfSwgd3AuZWxlbWVudC5jcmVhdGVFbGVtZW50KFJpY2hUZXh0LkNvbnRlbnQsIHtcbiAgICAgICAgdGFnTmFtZTogXCJsZWdlbmRcIixcbiAgICAgICAgdmFsdWU6IGF0dHJpYnV0ZXMubGVnZW5kXG4gICAgICB9KSwgXCIgXCIsIHdwLmVsZW1lbnQuY3JlYXRlRWxlbWVudChSaWNoVGV4dC5Db250ZW50LCB7XG4gICAgICAgIHRhZ05hbWU6IFwiZGl2XCIsXG4gICAgICAgIGNsYXNzTmFtZTogXCJjb250ZW50XCIsXG4gICAgICAgIHZhbHVlOiBhdHRyaWJ1dGVzLmNvbnRlbnRcbiAgICAgIH0pKTtcbiAgICB9XG4gIH1dLFxuICB0cmFuc2Zvcm1zOiB7XG4gICAgdG86IFt7XG4gICAgICB0eXBlOiAnYmxvY2snLFxuICAgICAgYmxvY2tzOiBbJ2NvcmUvcGFyYWdyYXBoJ10sXG4gICAgICB0cmFuc2Zvcm06IGZ1bmN0aW9uIHRyYW5zZm9ybShfcmVmMikge1xuICAgICAgICB2YXIgbGVnZW5kID0gX3JlZjIubGVnZW5kLFxuICAgICAgICAgICAgY29udGVudCA9IF9yZWYyLmNvbnRlbnQ7XG4gICAgICAgIHJldHVybiBjcmVhdGVCbG9jaygnY29yZS9wYXJhZ3JhcGgnLCB7XG4gICAgICAgICAgY29udGVudDogbGVnZW5kICsgJzxiciAvPicgKyBjb250ZW50XG4gICAgICAgIH0pO1xuICAgICAgfVxuICAgIH1dLFxuICAgIGZyb206IFt7XG4gICAgICB0eXBlOiAnYmxvY2snLFxuICAgICAgYmxvY2tzOiBbJ2NvcmUvcGFyYWdyYXBoJ10sXG4gICAgICB0cmFuc2Zvcm06IGZ1bmN0aW9uIHRyYW5zZm9ybShhdHRyaWJ1dGVzKSB7XG4gICAgICAgIHJldHVybiBjcmVhdGVCbG9jaygnbW0vZmllbGRzZXQnLCB7XG4gICAgICAgICAgY29udGVudDogYXR0cmlidXRlcy5jb250ZW50XG4gICAgICAgIH0pO1xuICAgICAgfVxuICAgIH1dXG4gIH0sXG4gIGVkaXQ6IGZ1bmN0aW9uIGVkaXQocHJvcHMpIHtcbiAgICB2YXIgYXR0cmlidXRlcyA9IHByb3BzLmF0dHJpYnV0ZXMsXG4gICAgICAgIHNldEF0dHJpYnV0ZXMgPSBwcm9wcy5zZXRBdHRyaWJ1dGVzO1xuICAgIHJldHVybiB3cC5lbGVtZW50LmNyZWF0ZUVsZW1lbnQoXCJmaWVsZHNldFwiLCB7XG4gICAgICBjbGFzc05hbWU6IFwibW0tZmllbGRzZXRcIlxuICAgIH0sIHdwLmVsZW1lbnQuY3JlYXRlRWxlbWVudChSaWNoVGV4dCwge1xuICAgICAgdGFnTmFtZTogXCJsZWdlbmRcIixcbiAgICAgIHZhbHVlOiBhdHRyaWJ1dGVzLmxlZ2VuZCxcbiAgICAgIHBsYWNlaG9sZGVyOiBfXygnRW50ZXIgYSBsYWJlbCcsICdtZmInKSxcbiAgICAgIG11bHRpbGluZTogZmFsc2UsXG4gICAgICBvbkNoYW5nZTogZnVuY3Rpb24gb25DaGFuZ2UodmFsdWUpIHtcbiAgICAgICAgc2V0QXR0cmlidXRlcyh7XG4gICAgICAgICAgbGVnZW5kOiB2YWx1ZVxuICAgICAgICB9KTtcbiAgICAgIH1cbiAgICB9KSwgXCIgXCIsIHdwLmVsZW1lbnQuY3JlYXRlRWxlbWVudChSaWNoVGV4dCwge1xuICAgICAgdGFnTmFtZTogXCJkaXZcIixcbiAgICAgIGNsYXNzTmFtZTogXCJjb250ZW50XCIsXG4gICAgICB2YWx1ZTogYXR0cmlidXRlcy5jb250ZW50LFxuICAgICAgcGxhY2Vob2xkZXI6IF9fKCdFbnRlciBzb21lIGNvbnRlbnQnLCAnbWZiJyksXG4gICAgICBtdWx0aWxpbmU6IGZhbHNlLFxuICAgICAgb25DaGFuZ2U6IGZ1bmN0aW9uIG9uQ2hhbmdlKHZhbHVlKSB7XG4gICAgICAgIHNldEF0dHJpYnV0ZXMoe1xuICAgICAgICAgIGNvbnRlbnQ6IHZhbHVlXG4gICAgICAgIH0pO1xuICAgICAgfVxuICAgIH0pKTtcbiAgfSxcbiAgc2F2ZTogZnVuY3Rpb24gc2F2ZShwcm9wcykge1xuICAgIHZhciBhdHRyaWJ1dGVzID0gcHJvcHMuYXR0cmlidXRlcztcbiAgICByZXR1cm4gd3AuZWxlbWVudC5jcmVhdGVFbGVtZW50KFwiZGl2XCIsIHtcbiAgICAgIGNsYXNzTmFtZTogXCJtbS1maWVsZHNldFwiXG4gICAgfSwgd3AuZWxlbWVudC5jcmVhdGVFbGVtZW50KFwiZmllbGRzZXRcIiwge1xuICAgICAgY2xhc3NOYW1lOiBcIm1tLWZpZWxkc2V0XCJcbiAgICB9LCB3cC5lbGVtZW50LmNyZWF0ZUVsZW1lbnQoUmljaFRleHQuQ29udGVudCwge1xuICAgICAgdGFnTmFtZTogXCJsZWdlbmRcIixcbiAgICAgIHZhbHVlOiBhdHRyaWJ1dGVzLmxlZ2VuZFxuICAgIH0pLCBcIiBcIiwgd3AuZWxlbWVudC5jcmVhdGVFbGVtZW50KFJpY2hUZXh0LkNvbnRlbnQsIHtcbiAgICAgIHRhZ05hbWU6IFwiZGl2XCIsXG4gICAgICBjbGFzc05hbWU6IFwiY29udGVudFwiLFxuICAgICAgdmFsdWU6IGF0dHJpYnV0ZXMuY29udGVudFxuICAgIH0pKSk7XG4gIH1cbn0pOyJdLCJtYXBwaW5ncyI6IkFBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBIiwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./blocks/fieldset.js\n");

/***/ })

/******/ });