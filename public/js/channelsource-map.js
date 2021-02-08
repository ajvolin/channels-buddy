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
    channelStartNumber: String,
    channels: Array
  }
}); // $(document).ready(function() {
//     var searchChannels = function() {
//         var search = encodeURI($("#search_channels").val());
//         var channelStatus = $('input[name="channel_status"]:checked').val();
//         var channelEnabledFilter = channelStatus !== '' ? '[data-channel-enabled="' + channelStatus + '"]' : '';
//         var searchChannelNumber = [search !== '' ?
//             '[data-channel-number*="' + search + '"]' :
//             '', channelEnabledFilter
//         ].filter(Boolean).join("");
//         var searchChannelName = [search !== '' ?
//             '[data-channel-name*="' + search.toUpperCase() + '"]' :
//             '', channelEnabledFilter
//         ].filter(Boolean).join("");
//         var searchChannelRemappedNumber = [search !== '' ?
//             '[data-channel-remapped-number*="' + search + '"]' :
//             '', channelEnabledFilter
//         ].filter(Boolean).join("");
//         var searchChannelCallSign = [search !== '' ?
//             '[data-channel-callsign*="' + search + '"]' :
//             '', channelEnabledFilter
//         ].filter(Boolean).join("");
//         var searchChannelStationId = [search !== '' ?
//             '[data-channel-station-id="' + search.toLowerCase() + '"]' :
//             '', channelEnabledFilter
//         ].filter(Boolean).join("");
//         var filter = [
//             searchChannelNumber,
//             searchChannelName,
//             searchChannelRemappedNumber,
//             searchChannelCallSign,
//             searchChannelStationId
//         ].filter(Boolean).join(",");
//         if (filter !== '') {
//             $("tr.channel-row").hide()
//                 .filter(filter)
//                 .show();
//         } else {
//             $("tr.channel-row").show();
//         }
//     };
//     var validateChannelNotDuplicated = function (el) {
//         var channelNumber = el.val();
//         if (channelNumber !== '' &&
//                 $('input.map-channel[value="'+channelNumber+'"]').not(el).length > 0 &&
//                 !el.hasClass("is-invalid")
//             ) {
//             el.addClass("is-invalid");
//             $("body").trigger("change");
//             return false;
//         } else if (channelNumber !== '' &&
//                 $('input.map-channel[value="'+channelNumber+'"]').not(el).length == 0 &&
//                 el.hasClass("is-invalid")) {
//             el.removeClass("is-invalid");
//             $("body").trigger("change");
//             return true;
//         } else if (channelNumber === '') {
//             $("body").trigger("change");
//             return true;
//         }
//     }
//     $('input[type="checkbox"].channel-status-checkbox').on('click', function(e) {
//         $(this).next().text($(this).next().text() == "Enabled" ? "Disabled" : "Enabled");
//         $(this).parent().parent().parent().attr('data-channel-enabled', $(this).prop("checked") ? "1" : "0");
//     });
//     $('#search_channels, input[name="channel_status"]').on('change keyup', function(e) {
//         searchChannels();
//     });
//     $('.map-channel').on('focus keyup', function(e) {
//         var el = $(this);
//         validateChannelNotDuplicated(el);
//     });
//     $('.map-channel').on('change', function(e) {
//         var el = $(this);
//         var channelNumber = el.val() ||
//             el.parent().parent().attr('data-channel-number');
//         el.attr('value', el.val());
//         el.parent()
//             .parent()
//             .attr('data-channel-remapped-number', channelNumber);
//     });
//     $('#channel_start_number').on('change', function(e) {
//         var channelNumber = $(this).val();
//         if (channelNumber !== '') {
//             $(".map-channel").each(function(i, e) {
//                 $(e).val(channelNumber);
//                 channelNumber++;
//             });
//         } else {
//             $(".map-channel").val('');
//         }
//         $(".map-channel").trigger('change');
//     });
//     $("body").on('change', function(e) {
//         if ($("input.map-channel.is-invalid").length > 0) {
//             $("#channelMapForm input[type='submit']").prop('disabled', true);
//             $("#duplicateChannelErrorMsg").show();
//         } else {
//             $("#channelMapForm input[type='submit']").prop('disabled', false);
//             $("#duplicateChannelErrorMsg").hide();
//         }
//     });
//     $("#channelMapForm input[type='submit']").on('click', function(e){
//         e.preventDefault();
//         $("#channelMapForm").submit();
//     });
//     var currentChannelEl;
//     var modal;
//     $(".open-channel-settings").on('click', function(e) {
//         e.preventDefault();
//     });
//     $("#channel-settings").on('show.bs.modal', function(event) {
//         modal = $(this);
//         currentChannelEl = $(event.relatedTarget);
//         $(".modal-title").text(
//             currentChannelEl.attr('data-channel-name')
//         );
//         modal.find("[name='customChannelLogo']").val(
//             currentChannelEl.siblings('input.custom-logo-input').val()
//         );
//         modal.find("[name='customChannelArt']").val(
//             currentChannelEl.siblings('input.custom-channel-art-input').val()
//         );
//     });
//     $("#save-channel-settings").on('click', function(e){
//         e.preventDefault();
//         currentChannelEl.siblings('input.custom-logo-input').val(
//             modal.find("[name='customChannelLogo']").val()
//         );
//         currentChannelEl.siblings('input.custom-channel-art-input').val(
//             modal.find("[name='customChannelArt']").val()
//         );
//         modal.modal('hide');
//     });
// });

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
  return _c("div", { staticClass: "row mt-4" }, [
    _c("div", { staticClass: "col-xl-10 offset-xl-1" }, [
      _c("div", { staticClass: "row mb-3" }, [
        _c("div", { staticClass: "col-xs-8 col-md-10 col-lg-10" }, [
          _c("h1", [_vm._v(_vm._s(_vm.source.display_name))]),
          _vm._v(" "),
          _c("div", { staticClass: "card" }, [
            _c("div", { staticClass: "card-body" }, [
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
              ]),
              _vm._v(" "),
              _vm.source.provides_guide ? _c("br") : _vm._e(),
              _vm._v(" "),
              _vm.source.provides_guide
                ? _c("small", { staticClass: "text-muted" }, [
                    _vm._v("XMLTV Guide URL: ")
                  ])
                : _vm._e(),
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
          ]),
          _vm._v(" "),
          _c("input", {
            staticClass: "form-control my-3",
            attrs: {
              type: "text",
              id: "search_channels",
              name: "search_channels",
              placeholder: "Search channels"
            }
          }),
          _vm._v(" "),
          _vm._m(0),
          _vm._v(" "),
          _vm._m(1),
          _vm._v(" "),
          _vm._m(2)
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-xs-4 col-md-2 col-lg-2" })
      ]),
      _vm._v(" "),
      _c(
        "form",
        {
          attrs: {
            action: _vm.route("channel-source.source.apply-map", {
              channelSource: _vm.source.source_name
            }),
            method: "POST",
            id: "channelMapForm"
          }
        },
        [
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-xs-8 col-md-10 col-lg-10" }, [
              _c(
                "table",
                {
                  staticClass: "table table-hover table-responsive",
                  attrs: { width: "100%" }
                },
                [
                  _c("caption", [_vm._v("List of channels")]),
                  _vm._v(" "),
                  _vm._m(3),
                  _vm._v(" "),
                  _c(
                    "tbody",
                    _vm._l(_vm.channels, function(channel) {
                      return _c("channel-source-table-row", {
                        key: channel.id,
                        attrs: { channel: channel }
                      })
                    }),
                    1
                  )
                ]
              )
            ]),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "col-xs-4 col-md-2 col-lg-2 align-left" },
              [
                _c("div", { staticClass: "form-group" }, [
                  _c("label", { attrs: { for: "channel_start_number" } }, [
                    _vm._v("Starting Channel Number")
                  ]),
                  _vm._v(" "),
                  _c("input", {
                    staticClass: "form-control text-center mx-auto",
                    attrs: {
                      type: "text",
                      id: "channel_start_number",
                      name: "channel_start_number"
                    },
                    domProps: { value: _vm.channelStartNumber }
                  }),
                  _vm._v(" "),
                  _c("small", [
                    _vm._v(
                      "Enter a starting number to automatically re-number the channels"
                    )
                  ])
                ]),
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
              ]
            )
          ])
        ]
      )
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      { staticClass: "custom-control custom-radio custom-control-inline" },
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
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      { staticClass: "custom-control custom-radio custom-control-inline" },
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
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      { staticClass: "custom-control custom-radio custom-control-inline" },
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
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "thead-light" }, [
      _c("tr", [
        _c(
          "th",
          {
            staticClass: "text-left",
            staticStyle: { padding: "10px", "max-width": "125px" },
            attrs: { scope: "col" }
          },
          [_vm._v("Source Channel")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { padding: "10px", "max-width": "300px" },
            attrs: { scope: "col" }
          },
          [_vm._v("Channel Number")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { padding: "10px" },
            attrs: { scope: "col" }
          },
          [_vm._v("Channel Status")]
        ),
        _vm._v(" "),
        _c("th", {
          staticClass: "text-center",
          staticStyle: { padding: "10px" },
          attrs: { scope: "col" }
        })
      ])
    ])
  }
]
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