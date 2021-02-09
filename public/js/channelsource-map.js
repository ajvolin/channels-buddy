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
      channelTableFields: [{
        key: 'id',
        label: 'Source Channel',
        sortable: false,
        "class": 'text-left align-middle'
      }, {
        key: 'mapped_channel_number',
        label: 'Channel Number',
        sortable: true,
        "class": 'text-center align-middle'
      }, {
        key: 'channel_enabled',
        label: 'Channel Status',
        sortable: false,
        "class": 'text-center align-middle'
      }, {
        key: 'channel_settings',
        label: '',
        sortable: false,
        "class": 'text-center align-middle'
      }],
      search: null,
      searchOn: ['number', 'name', 'mapped_channel_number', 'callSign', 'title', 'stationId'],
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
    }
  },
  created: function created() {
    this.channelRenumberStart = this.channelStartNumber;
  },
  mounted: function mounted() {
    var _this = this;

    this.dataLoading = true;
    axios.get(this.route('channel-source.source.get-channels', {
      channelSource: this.source.source_name
    })).then(function (response) {
      _this.channels = response.data;
    })["catch"](function (error) {
      console.log(error);
      _this.apiError = true;
    })["finally"](function () {
      return _this.dataLoading = false;
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
                      _c("b-card-text", [
                        _c("small", { staticClass: "text-muted" }, [
                          _vm._v("M3U Playlist URL:")
                        ]),
                        _vm._v(" "),
                        _c("code", [
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
                        ? _c("b-card-text", [
                            _c("small", { staticClass: "text-muted" }, [
                              _vm._v("XMLTV Guide URL: ")
                            ]),
                            _c("code", [
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
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "b-input-group",
                    { staticClass: "my-3" },
                    [
                      _c("b-form-input", {
                        attrs: {
                          id: "search-input",
                          type: "text",
                          placeholder: "Search channels",
                          debounce: "300"
                        },
                        model: {
                          value: _vm.search,
                          callback: function($$v) {
                            _vm.search = $$v
                          },
                          expression: "search"
                        }
                      }),
                      _vm._v(" "),
                      _c(
                        "b-input-group-append",
                        [
                          _c(
                            "b-button",
                            {
                              attrs: { disabled: !_vm.search },
                              on: {
                                click: function($event) {
                                  _vm.search = ""
                                }
                              }
                            },
                            [_c("i", { staticClass: "las la-fw la-times" })]
                          )
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass:
                        "custom-control custom-radio custom-control-inline"
                    },
                    [
                      _c("input", {
                        staticClass: "custom-control-input",
                        attrs: {
                          type: "radio",
                          id: "channel_status_any",
                          name: "channel_status",
                          value: "",
                          checked: ""
                        }
                      }),
                      _vm._v(" "),
                      _c(
                        "label",
                        {
                          staticClass: "custom-control-label",
                          attrs: { for: "channel_status_any" }
                        },
                        [_vm._v("All Channels")]
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass:
                        "custom-control custom-radio custom-control-inline"
                    },
                    [
                      _c("input", {
                        staticClass: "custom-control-input",
                        attrs: {
                          type: "radio",
                          id: "channel_status_enabled",
                          name: "channel_status",
                          value: "1"
                        }
                      }),
                      _vm._v(" "),
                      _c(
                        "label",
                        {
                          staticClass: "custom-control-label",
                          attrs: { for: "channel_status_enabled" }
                        },
                        [_vm._v("Enabled Channels")]
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass:
                        "custom-control custom-radio custom-control-inline"
                    },
                    [
                      _c("input", {
                        staticClass: "custom-control-input",
                        attrs: {
                          type: "radio",
                          id: "channel_status_disabled",
                          name: "channel_status",
                          value: "0"
                        }
                      }),
                      _vm._v(" "),
                      _c(
                        "label",
                        {
                          staticClass: "custom-control-label",
                          attrs: { for: "channel_status_disabled" }
                        },
                        [_vm._v("Disabled Channels")]
                      )
                    ]
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
                  _c("b-table", {
                    attrs: {
                      hover: "",
                      "head-variant": "light",
                      caption: "List of channels",
                      busy: _vm.dataLoading,
                      items: _vm.channels,
                      fields: _vm.channelTableFields,
                      filter: _vm.search,
                      "filter-included-fields": _vm.searchOn,
                      "primary-key": "id"
                    },
                    scopedSlots: _vm._u([
                      {
                        key: "table-busy",
                        fn: function() {
                          return [
                            _c(
                              "div",
                              { staticClass: "text-center text-success my-2" },
                              [
                                _c("b-spinner", { staticClass: "align-middle" })
                              ],
                              1
                            )
                          ]
                        },
                        proxy: true
                      },
                      {
                        key: "cell(id)",
                        fn: function(data) {
                          return [
                            data.item.logo
                              ? _c("img", {
                                  staticStyle: {
                                    "max-width": "60%",
                                    "max-height": "50px",
                                    "margin-bottom": "5px",
                                    filter: "drop-shadow(lightgray 1px 1px 1px)"
                                  },
                                  attrs: { src: data.item.logo }
                                })
                              : _c(
                                  "div",
                                  {
                                    staticClass: "guide-channel-name",
                                    staticStyle: {
                                      "font-size": "0.9em",
                                      padding: "19px 0"
                                    }
                                  },
                                  [_vm._v(_vm._s(data.item.id))]
                                ),
                            _vm._v(" "),
                            _c("div", { staticClass: "guide-channel-number" }, [
                              data.item.number
                                ? _c(
                                    "span",
                                    {
                                      staticClass: "badge badge-light",
                                      staticStyle: {
                                        "min-width": "4em",
                                        display: "inline-block",
                                        "margin-right": "1em"
                                      }
                                    },
                                    [_vm._v(_vm._s(data.item.number))]
                                  )
                                : _vm._e(),
                              _vm._v(" "),
                              _c(
                                "span",
                                { staticStyle: { "font-size": "0.7em" } },
                                [_vm._v(_vm._s(data.item.name))]
                              )
                            ])
                          ]
                        }
                      },
                      {
                        key: "cell(mapped_channel_number)",
                        fn: function(data) {
                          return [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: data.item.mapped_channel_number,
                                  expression: "data.item.mapped_channel_number"
                                }
                              ],
                              staticClass:
                                "form-control text-center mx-auto map-channel",
                              staticStyle: { "max-width": "250px" },
                              attrs: { type: "text" },
                              domProps: {
                                value: data.item.mapped_channel_number
                              },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    data.item,
                                    "mapped_channel_number",
                                    $event.target.value
                                  )
                                }
                              }
                            })
                          ]
                        }
                      },
                      {
                        key: "cell(channel_enabled)",
                        fn: function(data) {
                          return [
                            _c(
                              "b-form-checkbox",
                              {
                                attrs: { name: "check-button", switch: "" },
                                model: {
                                  value: data.item.channel_enabled,
                                  callback: function($$v) {
                                    _vm.$set(data.item, "channel_enabled", $$v)
                                  },
                                  expression: "data.item.channel_enabled"
                                }
                              },
                              [
                                _vm._v(
                                  "\n                            " +
                                    _vm._s(
                                      data.item.channel_enabled
                                        ? "Enabled"
                                        : "Disabled"
                                    ) +
                                    "\n                        "
                                )
                              ]
                            )
                          ]
                        }
                      },
                      {
                        key: "cell(channel_settings)",
                        fn: function(data) {
                          return [
                            _c(
                              "a",
                              {
                                staticClass: "open-channel-settings",
                                attrs: {
                                  href: "#",
                                  "aria-label": "Customize channel",
                                  title: "Customize channel",
                                  "data-channel-name": data.item.name,
                                  "data-toggle": "modal",
                                  "data-target": "#channel-settings"
                                }
                              },
                              [
                                _c("i", {
                                  staticClass: "las la-fw la-2x la-cog"
                                })
                              ]
                            )
                          ]
                        }
                      }
                    ])
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
                  attrs: { type: "submit", value: "Save Channel Map" }
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
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Map_vue_vue_type_template_id_02a8221c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Map.vue?vue&type=template&id=02a8221c& */ "./resources/js/pages/channelsource/Map.vue?vue&type=template&id=02a8221c&");
/* harmony import */ var _Map_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Map.vue?vue&type=script&lang=js& */ "./resources/js/pages/channelsource/Map.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





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
/*! exports provided: default */
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