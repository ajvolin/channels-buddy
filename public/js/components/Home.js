(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["Home"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/Home.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/Home.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'Home',
  props: {
    title: String
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/Home.vue?vue&type=template&id=b3c5cf30&":
/*!**************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/Home.vue?vue&type=template&id=b3c5cf30& ***!
  \**************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "row mt-4" }, [
    _c("div", { staticClass: "col-xl-10 offset-xl-1" }, [
      _vm._m(0),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-sm" }, [
          _c("div", { staticClass: "card bg-light" }, [
            _vm._m(1),
            _vm._v(" "),
            _c("ul", { staticClass: "list-group list-group-flush" }, [
              _vm._v(
                "\n                        @forelse($channelsSources as $src => $srcName)\n                        "
              ),
              _c(
                "a",
                {
                  staticClass: "list-group-item list-group-item-action",
                  attrs: { href: "" }
                },
                [_vm._v(_vm._s(_vm.$srcName))]
              ),
              _vm._v(
                "\n                        @empty\n                        "
              ),
              _vm._m(2),
              _vm._v(
                "\n                        @endforelse\n                    "
              )
            ])
          ])
        ]),
        _vm._v(" "),
        _vm._m(3)
      ]),
      _vm._v(" "),
      _c("hr"),
      _vm._v(" "),
      _vm._m(4)
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "row" }, [
      _c("div", { staticClass: "col-sm" }, [
        _c("h4", [
          _vm._v(
            "\n                    Manage Channel Sources\n                "
          )
        ]),
        _vm._v(" "),
        _c("hr")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "card-body" }, [
      _c("h5", { staticClass: "card-title" }, [_vm._v("Channels DVR")]),
      _vm._v(" "),
      _c("h6", { staticClass: "card-subtitle text-muted" }, [
        _vm._v(
          "\n                            Remap channels and export M3U playlists and XMLTV guide data from your Channels DVR server\n                        "
        )
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("li", { staticClass: "list-group-item text-center" }, [
      _c("strong", [_vm._v("No Channels DVR Server Configured")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm" }, [
      _c("div", { staticClass: "card bg-light" }, [
        _c("div", { staticClass: "card-body" }, [
          _c("h5", { staticClass: "card-title" }, [
            _vm._v("External Source Providers")
          ]),
          _vm._v(" "),
          _c("h6", { staticClass: "card-subtitle text-muted" }, [
            _vm._v(
              "\n                            Set channel numbers and export M3U playlists and XMLTV guide data from external source providers\n                        "
            )
          ])
        ]),
        _vm._v(" "),
        _c("ul", { staticClass: "list-group list-group-flush" }, [
          _vm._v(
            "\n                        @forelse($channelSources->getChannelSourceProviders() as $value)\n                        "
          ),
          _c("a", {
            staticClass: "list-group-item list-group-item-action",
            attrs: { href: "" }
          }),
          _vm._v("\n                        @empty\n                        "),
          _c("li", { staticClass: "list-group-item text-center" }, [
            _c("strong", [_vm._v("No External Source Providers Configured")])
          ]),
          _vm._v("\n                        @endforelse\n                    ")
        ])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "row" }, [
      _c("div", { staticClass: "col-sm" }, [
        _c("div", { staticClass: "card bg-light" }, [
          _c("div", { staticClass: "card-body" }, [
            _c("h5", { staticClass: "card-title" }, [
              _vm._v("Help / Instructions")
            ]),
            _vm._v(" "),
            _c("h6", { staticClass: "card-subtitle" }, [
              _vm._v(
                "\n                            Mapping Channel Numbers\n                        "
              )
            ]),
            _vm._v(" "),
            _c("p", { staticClass: "card-text" }, [
              _vm._v(
                "\n                            Leave the Channel Number field empty to use the original channel number. For external sources, you can use the Starting Channel Number field to automatically number all channels starting with the entered number.\n                        "
              )
            ]),
            _vm._v(" "),
            _c("hr"),
            _vm._v(" "),
            _c("h6", { staticClass: "card-subtitle" }, [
              _vm._v(
                "\n                            Channels DVR Sources - M3U Playlist Options\n                        "
              )
            ]),
            _vm._v(" "),
            _c("p", { staticClass: "card-text" }, [
              _vm._v("\n                            Append "),
              _c("code", [_vm._v("?max_number=CHANNEL_NUMBER")]),
              _vm._v(
                " to the playlist URL to only include channel numbers up to and including the number provided.\n                        "
              )
            ]),
            _vm._v(" "),
            _c("hr"),
            _vm._v(" "),
            _c("h6", { staticClass: "card-subtitle" }, [
              _vm._v(
                "\n                            All Sources - XMLTV Guide Options\n                        "
              )
            ]),
            _vm._v(" "),
            _c("p", { staticClass: "card-text" }, [
              _vm._v("\n                            Append "),
              _c("code", [_vm._v("?days=")]),
              _vm._v(" or "),
              _c("code", [_vm._v("?hours=")]),
              _vm._v(" or "),
              _c("code", [_vm._v("?minutes=")]),
              _vm._v(" or "),
              _c("code", [_vm._v("?seconds=")]),
              _vm._v(
                " to the XMLTV guide URL to export guide data for the provided duration.\n                        "
              )
            ])
          ])
        ])
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/pages/Home.vue":
/*!*************************************!*\
  !*** ./resources/js/pages/Home.vue ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Home_vue_vue_type_template_id_b3c5cf30___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Home.vue?vue&type=template&id=b3c5cf30& */ "./resources/js/pages/Home.vue?vue&type=template&id=b3c5cf30&");
/* harmony import */ var _Home_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Home.vue?vue&type=script&lang=js& */ "./resources/js/pages/Home.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Home_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Home_vue_vue_type_template_id_b3c5cf30___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Home_vue_vue_type_template_id_b3c5cf30___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/Home.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/Home.vue?vue&type=script&lang=js&":
/*!**************************************************************!*\
  !*** ./resources/js/pages/Home.vue?vue&type=script&lang=js& ***!
  \**************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./Home.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/Home.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/Home.vue?vue&type=template&id=b3c5cf30&":
/*!********************************************************************!*\
  !*** ./resources/js/pages/Home.vue?vue&type=template&id=b3c5cf30& ***!
  \********************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_template_id_b3c5cf30___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./Home.vue?vue&type=template&id=b3c5cf30& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/Home.vue?vue&type=template&id=b3c5cf30&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_template_id_b3c5cf30___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_template_id_b3c5cf30___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);