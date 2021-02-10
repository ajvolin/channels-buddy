(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["channelsource-Map"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/channelsource/Map.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/channelsource/Map.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  metaInfo: function metaInfo() {
    return {
      title: "".concat(this.title)
    };
  },
  name: 'ChannelSourceMap',
  props: {
    title: String,
    source: Object,
    channelStartNumber: Number
  },
  data: function data() {
    return {
      apiError: false,
      dataLoading: false,
      channels: [],
      channelRenumberStart: null
    };
  },
  methods: {
    renumberChannels: function renumberChannels(value) {
      var currentNumber = value;
      this.channels.forEach(function (o, i, a) {
        a[i].mapped_channel_number = currentNumber;
        currentNumber++;
      });
    },
    saveChannel: function saveChannel(channel) {
      var _this = this;

      axios.put(this.route('channel-source.source.update-channel', {
        channelSource: this.source.source_name
      }), {
        channel: channel
      }).then(function (response) {
        console.log('Updated channel ' + _this.source.display_name + ': ' + channel.id);
        console.log(response.data);
      })["catch"](function (error) {
        console.log(error);
      });
    },
    saveChannels: function saveChannels() {
      var _this2 = this;

      axios.put(this.route('channel-source.source.update-channels', {
        channelSource: this.source.source_name
      }), {
        channels: this.channels
      }).then(function (response) {
        console.log('Updated channels for ' + _this2.source.display_name);
        console.log(response.data);
      })["catch"](function (error) {
        console.log(error);
      });
    }
  },
  created: function created() {
    this.channelRenumberStart = this.channelStartNumber;
  },
  mounted: function mounted() {
    var _this3 = this;

    this.dataLoading = true;
    axios.get(this.route('channel-source.source.get-channels', {
      channelSource: this.source.source_name
    })).then(function (response) {
      _this3.channels = response.data; // console.log(this.channels)
    })["catch"](function (error) {
      console.log(error);
      _this3.apiError = true;
    })["finally"](function () {
      return _this3.dataLoading = false;
    });
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/channelsource/Map.vue?vue&type=template&id=02a8221c&":
/*!***************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/channelsource/Map.vue?vue&type=template&id=02a8221c& ***!
  \***************************************************************************************************************************************************************************************************************/
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
  return _c(
    "b-row",
    { staticClass: "mt-4" },
    [
      _c(
        "b-col",
        { attrs: { xl: "10", "offset-xl": "1" } },
        [
          _c(
            "b-row",
            { staticClass: "mb-3" },
            [
              _c(
                "b-col",
                { attrs: { xs: "8", md: "10", lg: "10" } },
                [
                  _c("h1", [_vm._v(_vm._s(_vm.source.display_name))]),
                  _vm._v(" "),
                  _c(
                    "b-card",
                    { attrs: { "bg-variant": "white" } },
                    [
                      _c("b-list-group", { staticClass: "list-unstyled" }, [
                        _c("li", [
                          _c("small", { staticClass: "text-muted" }, [
                            _vm._v("M3U Playlist URL: ")
                          ]),
                          _vm._v(" "),
                          _c("code", { staticClass: "user-select-all" }, [
                            _vm._v(
                              _vm._s(
                                _vm.route("channel-source.source.playlist", {
                                  channelSource: _vm.source.source_name
                                })
                              )
                            )
                          ])
                        ]),
                        _vm._v(" "),
                        _vm.source.provides_guide
                          ? _c("li", [
                              _c("small", { staticClass: "text-muted" }, [
                                _vm._v("XMLTV Guide URL: ")
                              ]),
                              _c("code", { staticClass: "user-select-all" }, [
                                _vm._v(
                                  _vm._s(
                                    _vm.route("channel-source.source.guide", {
                                      channelSource: _vm.source.source_name
                                    })
                                  )
                                )
                              ])
                            ])
                          : _vm._e()
                      ])
                    ],
                    1
                  )
                ],
                1
              )
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "b-row",
            { staticClass: "mb-3" },
            [
              _c(
                "b-col",
                { attrs: { xs: "8", md: "10", lg: "10" } },
                [
                  _c("channel-source-table", {
                    attrs: {
                      channels: _vm.channels,
                      isBusy: _vm.dataLoading,
                      saveChannel: _vm.saveChannel
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c("b-col", { attrs: { xs: "4", md: "2", lg: "2" } }, [
                _c(
                  "div",
                  { staticClass: "form-group" },
                  [
                    _c("label", { attrs: { for: "channel_start_number" } }, [
                      _vm._v("Starting Channel Number")
                    ]),
                    _vm._v(" "),
                    _c("b-form-input", {
                      staticClass: "text-center mx-auto",
                      attrs: {
                        id: "channel_start_number",
                        type: "number",
                        placeholder: "Starting channel number",
                        number: "",
                        debounce: "300"
                      },
                      on: { update: _vm.renumberChannels },
                      model: {
                        value: _vm.channelRenumberStart,
                        callback: function($$v) {
                          _vm.channelRenumberStart = $$v
                        },
                        expression: "channelRenumberStart"
                      }
                    }),
                    _vm._v(" "),
                    _c("small", [
                      _vm._v(
                        "Enter a starting number to automatically re-number the channels"
                      )
                    ])
                  ],
                  1
                ),
                _vm._v(" "),
                _c("input", {
                  staticClass: "btn btn-primary",
                  attrs: { type: "submit", value: "Save Channel Map" },
                  on: { click: _vm.saveChannels }
                }),
                _vm._v(" "),
                _c(
                  "span",
                  {
                    staticClass: "text-danger",
                    staticStyle: { display: "none" },
                    attrs: { id: "duplicateChannelErrorMsg" }
                  },
                  [_vm._v("Duplicate channel numbers detected.")]
                )
              ])
            ],
            1
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/pages/channelsource/Map.vue":
/*!**************************************************!*\
  !*** ./resources/js/pages/channelsource/Map.vue ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Map_vue_vue_type_template_id_02a8221c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Map.vue?vue&type=template&id=02a8221c& */ "./resources/js/pages/channelsource/Map.vue?vue&type=template&id=02a8221c&");
/* harmony import */ var _Map_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Map.vue?vue&type=script&lang=js& */ "./resources/js/pages/channelsource/Map.vue?vue&type=script&lang=js&");
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _Map_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _Map_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Map_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Map_vue_vue_type_template_id_02a8221c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Map_vue_vue_type_template_id_02a8221c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/channelsource/Map.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/channelsource/Map.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./resources/js/pages/channelsource/Map.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Map_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Map.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/channelsource/Map.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Map_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/channelsource/Map.vue?vue&type=template&id=02a8221c&":
/*!*********************************************************************************!*\
  !*** ./resources/js/pages/channelsource/Map.vue?vue&type=template&id=02a8221c& ***!
  \*********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Map_vue_vue_type_template_id_02a8221c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Map.vue?vue&type=template&id=02a8221c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/channelsource/Map.vue?vue&type=template&id=02a8221c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Map_vue_vue_type_template_id_02a8221c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Map_vue_vue_type_template_id_02a8221c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);