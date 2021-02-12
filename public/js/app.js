(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/app"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/BInertiaLink.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/BInertiaLink.vue?vue&type=script&lang=js& ***!
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
/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'BInertiaLink',
  props: ['to']
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Navbar.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Navbar.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'Navbar',
  props: {
    items: Array
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SourceProviderCard.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/SourceProviderCard.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'SourceProviderCard',
  props: {
    title: String,
    subtitle: String,
    noSourcesMessage: String,
    sourceProvider: Array,
    sourceRoute: String
  },
  methods: {
    hasSources: function hasSources(provider) {
      return provider.length > 0;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/channels/ChannelsTable.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/channels/ChannelsTable.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'ChannelsTable',
  props: {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/channels/ChannelsTableRow.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/channels/ChannelsTableRow.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'ChannelsTableRow',
  props: {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/channelsource/ChannelSourceChannelModal.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/channelsource/ChannelSourceChannelModal.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  name: 'ChannelSourceChannelModel',
  props: {
    channel: Object,
    getChannelAttribute: Function,
    saveChannel: Function
  },
  data: function data() {
    return {
      saving: false,
      inputDebounce: 300,
      originalChannel: null,
      channelStatus: this.channel.channel_enabled
    };
  },
  mounted: function mounted() {
    this.cloneOriginalChannel();
  },
  methods: {
    callSaveChannel: function callSaveChannel() {
      var _this = this;

      this.saving = true;
      this.channel.channel_enabled = this.channelStatus;
      this.saveChannel(this.channel, function () {
        _this.saving = false;

        _this.cloneOriginalChannel();

        _this.$bvModal.hide(_this.channel.id);
      });
    },
    cancelEdit: function cancelEdit() {
      var _this2 = this;

      Object.keys(this.channel.customizations).forEach(function (key) {
        _this2.channel.customizations[key] = _this2.originalChannel.customizations[key];
      });
      this.channel.channel_enabled = this.originalChannel.channel_enabled;
      this.channelStatus = this.channel.channel_enabled;
      this.$bvModal.hide(this.channel.id);
    },
    confirmMsgBox: function confirmMsgBox(message, callback) {
      this.$bvModal.msgBoxConfirm(message, {
        size: 'sm',
        buttonSize: 'sm',
        okVariant: 'danger',
        okTitle: 'Yes',
        centered: true,
        hideHeaderClose: true,
        noCloseOnBackdrop: true
      }).then(function (value) {
        if (value) {
          callback();
        }
      })["catch"](function (err) {});
    },
    cloneOriginalChannel: function cloneOriginalChannel() {
      this.originalChannel = JSON.parse(JSON.stringify(this.channel));
    },
    handleHide: function handleHide(event) {
      if (event.trigger == 'esc' || event.trigger == 'backdrop') {
        this.cancelEdit();
      }
    },
    resetCustomizations: function resetCustomizations() {
      var _this3 = this;

      this.confirmMsgBox('Are you sure?', function () {
        Object.keys(_this3.channel.customizations).forEach(function (key) {
          _this3.channel.customizations[key] = null;
        });
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/channelsource/ChannelSourceTable.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/channelsource/ChannelSourceTable.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'ChannelSourceTable',
  props: {
    channels: Array,
    isBusy: Boolean,
    saveChannel: Function
  },
  computed: {
    channelFilter: function channelFilter() {
      if ((this.channelSearch == '' || this.channelSearch === null) && this.channelStatusFilterOptions[this.channelStatusFilterSelected].value === null) {
        return null;
      }

      return [this.channelSearch !== null && this.channelSearch != '' ? this.channelSearch : null, this.channelStatusFilterOptions[this.channelStatusFilterSelected].value];
    }
  },
  data: function data() {
    return {
      channelSearch: null,
      channelStatusFilterSelected: 0,
      channelStatusFilterOptions: [{
        value: null,
        text: 'All Channels'
      }, {
        value: true,
        text: 'Enabled Channels'
      }, {
        value: false,
        text: 'Disabled Channels'
      }],
      channelTableFields: [{
        key: 'name',
        label: 'Source Channel',
        sortable: false,
        "class": 'text-left align-middle'
      }, {
        key: 'mapped_channel_number',
        label: 'Channel Number',
        sortable: false,
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
        "class": 'align-middle'
      }],
      searchOn: ['number', 'name', 'mapped_channel_number', 'callSign', 'title', 'stationId']
    };
  },
  methods: {
    filterChannelsTable: function filterChannelsTable(row, filter) {
      var searchValues = [];
      this.searchOn.forEach(function (k) {
        if (row[k]) {
          searchValues.push(row[k]);
        }
      });
      var searchMatch = filter[0] !== null ? searchValues.join(' ').toLowerCase().includes(filter[0].toLowerCase()) : false;

      if (filter[0] !== null && filter[1] !== null) {
        return searchMatch && row.channel_enabled == filter[1];
      } else {
        return searchMatch || row.channel_enabled == filter[1];
      }
    },
    getChannelAttribute: function getChannelAttribute(channel, attribute) {
      return channel.customizations[attribute] || channel[attribute];
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/layouts/BlankLayout.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/layouts/BlankLayout.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'BlankLayout'
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/layouts/MainLayout.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/layouts/MainLayout.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _BlankLayout_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./BlankLayout.vue */ "./resources/js/layouts/BlankLayout.vue");
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    BlankLayout: _BlankLayout_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  name: 'MainLayout',
  props: {
    navbarItems: Array
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/BInertiaLink.vue?vue&type=template&id=1b0482fd&":
/*!***************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/BInertiaLink.vue?vue&type=template&id=1b0482fd& ***!
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
  return _c("inertia-link", { attrs: { href: _vm.to } }, [_vm._t("default")], 2)
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Navbar.vue?vue&type=template&id=6dde423b&":
/*!*********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Navbar.vue?vue&type=template&id=6dde423b& ***!
  \*********************************************************************************************************************************************************************************************************/
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
    "b-navbar",
    {
      staticClass: "my-3 border rounded",
      attrs: {
        border: "dark",
        toggleable: "md",
        type: "light",
        variant: "light"
      }
    },
    [
      _c(
        "inertia-link",
        { staticClass: "navbar-brand", attrs: { href: _vm.route("home") } },
        [_vm._v("Channels Buddy")]
      ),
      _vm._v(" "),
      _c("b-navbar-toggle", {
        attrs: { target: "nav-collapse", label: "Toggle navigation" }
      }),
      _vm._v(" "),
      _c(
        "b-collapse",
        { attrs: { id: "nav-collapse", "is-nav": "" } },
        [
          _c(
            "b-navbar-nav",
            [
              _vm._l(_vm.items, function(item, key) {
                return [
                  item.type == "link"
                    ? _c(
                        "b-nav-item",
                        {
                          key: "navbar_item_" + key,
                          attrs: {
                            to: item.url,
                            active: item.isActive,
                            disabled: item.isDisabled,
                            "router-component-name": "b-inertia-link"
                          }
                        },
                        [
                          _vm._v(
                            "\n                    " +
                              _vm._s(item.text) +
                              "\n                "
                          )
                        ]
                      )
                    : item.type == "text"
                    ? _c("b-nav-text", { key: "navbar_item_" + key }, [
                        _vm._v(
                          "\n                    " +
                            _vm._s(item.text) +
                            "\n                "
                        )
                      ])
                    : item.type == "dropdown"
                    ? _c(
                        "b-nav-item-dropdown",
                        {
                          key: "navbar_item_" + key,
                          attrs: { text: item.text }
                        },
                        _vm._l(item.items, function(dd_item, dd_key) {
                          return _c(
                            "b-dropdown-item",
                            {
                              key:
                                "navbar_item_" +
                                key +
                                "_dropdown_item_" +
                                dd_key,
                              attrs: {
                                to: dd_item.url,
                                active: dd_item.isActive,
                                disabled: dd_item.isDisabled,
                                "router-component-name": "b-inertia-link"
                              }
                            },
                            [
                              _vm._v(
                                "\n                        " +
                                  _vm._s(dd_item.text) +
                                  "\n                    "
                              )
                            ]
                          )
                        }),
                        1
                      )
                    : _vm._e()
                ]
              })
            ],
            2
          ),
          _vm._v(" "),
          _c(
            "b-navbar-nav",
            { staticClass: "ml-auto" },
            [
              _c(
                "inertia-link",
                { staticClass: "nav-link", attrs: { href: _vm.route("log") } },
                [_vm._v("Log")]
              )
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SourceProviderCard.vue?vue&type=template&id=4ab947f2&":
/*!*********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/SourceProviderCard.vue?vue&type=template&id=4ab947f2& ***!
  \*********************************************************************************************************************************************************************************************************************/
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
    "b-card",
    { attrs: { "bg-variant": "light", "no-body": "" } },
    [
      _c(
        "b-card-body",
        [
          _c("b-card-title", { attrs: { "title-tag": "h5" } }, [
            _vm._v(_vm._s(_vm.title))
          ]),
          _vm._v(" "),
          _c("b-card-sub-title", [_vm._v(_vm._s(_vm.subtitle))])
        ],
        1
      ),
      _vm._v(" "),
      _vm.hasSources(_vm.sourceProvider)
        ? _c(
            "b-list-group",
            { attrs: { flush: "" } },
            _vm._l(_vm.sourceProvider, function(source) {
              return _c(
                "b-list-group-item",
                {
                  key: source.source_name,
                  attrs: {
                    to: _vm.route(_vm.sourceRoute, source.source_name),
                    "router-component-name": "b-inertia-link"
                  }
                },
                [
                  _vm._v(
                    "\n            " +
                      _vm._s(source.display_name) +
                      "\n        "
                  )
                ]
              )
            }),
            1
          )
        : _c(
            "b-list-group",
            { attrs: { flush: "" } },
            [
              _c("b-list-group-item", { staticClass: "text-center" }, [
                _c("strong", [_vm._v(_vm._s(_vm.noSourcesMessage))])
              ])
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/channels/ChannelsTable.vue?vue&type=template&id=21c70a4a&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/channels/ChannelsTable.vue?vue&type=template&id=21c70a4a& ***!
  \*************************************************************************************************************************************************************************************************************************/
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
  return _c("div")
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/channels/ChannelsTableRow.vue?vue&type=template&id=1df9ba60&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/channels/ChannelsTableRow.vue?vue&type=template&id=1df9ba60& ***!
  \****************************************************************************************************************************************************************************************************************************/
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
  return _c("div")
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/channelsource/ChannelSourceChannelModal.vue?vue&type=template&id=03a78908&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/channelsource/ChannelSourceChannelModal.vue?vue&type=template&id=03a78908& ***!
  \******************************************************************************************************************************************************************************************************************************************/
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
  return _vm.channel
    ? _c(
        "b-modal",
        {
          attrs: {
            id: _vm.channel.id,
            "button-size": "sm",
            centered: "",
            "content-class": "shadow",
            "header-bg-variant": "light",
            lazy: "",
            scrollable: "",
            static: "",
            title: "Edit channel"
          },
          on: { hide: _vm.handleHide },
          scopedSlots: _vm._u(
            [
              {
                key: "modal-header",
                fn: function() {
                  return [
                    _c("h5", { staticClass: "my-auto" }, [
                      _vm._v(_vm._s(_vm.channel.name))
                    ]),
                    _vm._v(" "),
                    _vm.getChannelAttribute(_vm.channel, "logo")
                      ? _c("img", {
                          staticClass: "img-fluid float-right",
                          staticStyle: {
                            "max-height": "50px",
                            filter: "drop-shadow(darkgray 1px 1px 1px)"
                          },
                          attrs: {
                            src: _vm.getChannelAttribute(_vm.channel, "logo"),
                            alt: "Channel logo"
                          }
                        })
                      : _vm._e()
                  ]
                },
                proxy: true
              },
              {
                key: "modal-footer",
                fn: function() {
                  return [
                    _c(
                      "div",
                      { staticClass: "mr-auto" },
                      [
                        _c(
                          "b-button",
                          {
                            attrs: { size: "sm", variant: "danger" },
                            on: {
                              click: function($event) {
                                return _vm.resetCustomizations()
                              }
                            }
                          },
                          [_vm._v("Clear customizations")]
                        )
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "float-right" },
                      [
                        _c(
                          "b-button",
                          {
                            attrs: { size: "sm" },
                            on: {
                              click: function($event) {
                                return _vm.cancelEdit()
                              }
                            }
                          },
                          [_vm._v("Cancel")]
                        ),
                        _vm._v(" "),
                        _c(
                          "b-button",
                          {
                            attrs: { size: "sm", variant: "primary" },
                            on: {
                              click: function($event) {
                                return _vm.callSaveChannel()
                              }
                            }
                          },
                          [
                            _vm.saving
                              ? _c("b-spinner", { attrs: { small: "" } })
                              : _vm._e(),
                            _vm._v(
                              "\n                " +
                                _vm._s(_vm.saving ? "Saving" : "Save") +
                                "\n            "
                            )
                          ],
                          1
                        )
                      ],
                      1
                    )
                  ]
                },
                proxy: true
              }
            ],
            null,
            false,
            3568606270
          )
        },
        [
          _vm._v(" "),
          _c(
            "b-card",
            { attrs: { "bg-variant": "white", "no-body": "" } },
            [
              _vm.getChannelAttribute(_vm.channel, "channelArt")
                ? _c("b-card-img", {
                    staticStyle: { background: "#000" },
                    attrs: {
                      top: "",
                      src: _vm.getChannelAttribute(_vm.channel, "channelArt"),
                      alt: "Channel art"
                    }
                  })
                : _vm._e(),
              _vm._v(" "),
              _c(
                "b-card-body",
                [
                  _c("h5", { staticClass: "d-inline-block" }, [
                    _vm._v("Channel")
                  ]),
                  _vm._v(" "),
                  _c("b-form-checkbox", {
                    staticClass: "my-auto float-right d-inline-block",
                    attrs: { name: "check-button", switch: "" },
                    model: {
                      value: _vm.channelStatus,
                      callback: function($$v) {
                        _vm.channelStatus = $$v
                      },
                      expression: "channelStatus"
                    }
                  }),
                  _vm._v(" "),
                  _c(
                    "b-form-group",
                    {
                      attrs: {
                        label: "Channel Name",
                        "label-for": "channelName",
                        description: _vm.channel.name
                      }
                    },
                    [
                      _c("b-form-input", {
                        attrs: {
                          id: "channelName",
                          type: "text",
                          placeholder: "Channel name",
                          debounce: _vm.inputDebounce
                        },
                        model: {
                          value: _vm.channel.customizations.name,
                          callback: function($$v) {
                            _vm.$set(_vm.channel.customizations, "name", $$v)
                          },
                          expression: "channel.customizations.name"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "b-form-group",
                    {
                      attrs: {
                        label: "Call Sign",
                        "label-for": "channelCallSign",
                        description: _vm.channel.callSign || ""
                      }
                    },
                    [
                      _c("b-form-input", {
                        attrs: {
                          id: "channelCallSign",
                          type: "text",
                          placeholder: "Call Sign",
                          debounce: _vm.inputDebounce
                        },
                        model: {
                          value: _vm.channel.customizations.callSign,
                          callback: function($$v) {
                            _vm.$set(
                              _vm.channel.customizations,
                              "callSign",
                              $$v
                            )
                          },
                          expression: "channel.customizations.callSign"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "b-form-group",
                    {
                      attrs: {
                        label: "Category",
                        "label-for": "channelCategory",
                        description: _vm.channel.category || ""
                      }
                    },
                    [
                      _c("b-form-input", {
                        attrs: {
                          id: "channelCategory",
                          type: "text",
                          placeholder: "Category",
                          debounce: _vm.inputDebounce
                        },
                        model: {
                          value: _vm.channel.customizations.category,
                          callback: function($$v) {
                            _vm.$set(
                              _vm.channel.customizations,
                              "category",
                              $$v
                            )
                          },
                          expression: "channel.customizations.category"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("hr"),
                  _vm._v(" "),
                  _c("h5", [_vm._v("Images")]),
                  _vm._v(" "),
                  _c(
                    "b-form-group",
                    {
                      attrs: {
                        label: "Channel Logo",
                        "label-for": "channelLogo",
                        description: _vm.channel.logo || ""
                      }
                    },
                    [
                      _c("b-form-input", {
                        attrs: {
                          id: "channelLogo",
                          type: "url",
                          placeholder: "URL to channel logo image",
                          debounce: _vm.inputDebounce
                        },
                        model: {
                          value: _vm.channel.customizations.logo,
                          callback: function($$v) {
                            _vm.$set(_vm.channel.customizations, "logo", $$v)
                          },
                          expression: "channel.customizations.logo"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "b-form-group",
                    {
                      attrs: {
                        label: "Channel Art",
                        "label-for": "channelArt",
                        description: _vm.channel.channelArt || ""
                      }
                    },
                    [
                      _c("b-form-input", {
                        attrs: {
                          id: "channelArt",
                          type: "url",
                          placeholder: "URL to channel art image",
                          debounce: _vm.inputDebounce
                        },
                        model: {
                          value: _vm.channel.customizations.channelArt,
                          callback: function($$v) {
                            _vm.$set(
                              _vm.channel.customizations,
                              "channelArt",
                              $$v
                            )
                          },
                          expression: "channel.customizations.channelArt"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("hr"),
                  _vm._v(" "),
                  _c("h5", [_vm._v("Guide Details")]),
                  _vm._v(" "),
                  _c(
                    "b-form-group",
                    {
                      attrs: {
                        label: "Channel Title",
                        "label-for": "channelTitle",
                        description: _vm.channel.title || ""
                      }
                    },
                    [
                      _c("b-form-input", {
                        attrs: {
                          id: "channelTitle",
                          type: "text",
                          placeholder:
                            "Channel title (used for guide timeslot)",
                          debounce: _vm.inputDebounce
                        },
                        model: {
                          value: _vm.channel.customizations.title,
                          callback: function($$v) {
                            _vm.$set(_vm.channel.customizations, "title", $$v)
                          },
                          expression: "channel.customizations.title"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "b-form-group",
                    {
                      attrs: {
                        label: "Channel Description",
                        "label-for": "channelDescr",
                        description: _vm.channel.description || ""
                      }
                    },
                    [
                      _c("b-form-textarea", {
                        attrs: {
                          id: "channelDescr",
                          rows: "3",
                          "max-rows": "6",
                          placeholder:
                            "Channel description (used for guide timeslot)",
                          debounce: _vm.inputDebounce
                        },
                        model: {
                          value: _vm.channel.customizations.description,
                          callback: function($$v) {
                            _vm.$set(
                              _vm.channel.customizations,
                              "description",
                              $$v
                            )
                          },
                          expression: "channel.customizations.description"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "b-form-group",
                    {
                      attrs: {
                        label: "Gracenote Station ID",
                        "label-for": "channelStationId",
                        description: _vm.channel.stationId || ""
                      }
                    },
                    [
                      _c("b-form-input", {
                        attrs: {
                          id: "channelStationId",
                          type: "text",
                          placeholder: "Gracenote Station ID",
                          debounce: _vm.inputDebounce
                        },
                        model: {
                          value: _vm.channel.customizations.stationId,
                          callback: function($$v) {
                            _vm.$set(
                              _vm.channel.customizations,
                              "stationId",
                              $$v
                            )
                          },
                          expression: "channel.customizations.stationId"
                        }
                      })
                    ],
                    1
                  )
                ],
                1
              )
            ],
            1
          )
        ],
        1
      )
    : _vm._e()
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/channelsource/ChannelSourceTable.vue?vue&type=template&id=3b5b93a8&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/channelsource/ChannelSourceTable.vue?vue&type=template&id=3b5b93a8& ***!
  \***********************************************************************************************************************************************************************************************************************************/
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
    "div",
    [
      _c(
        "b-input-group",
        { staticClass: "mb-3" },
        [
          _c("b-form-input", {
            staticClass: "border border-secondary",
            attrs: {
              id: "search-input",
              type: "text",
              placeholder: "Search channels",
              disabled: _vm.isBusy,
              debounce: "300"
            },
            model: {
              value: _vm.channelSearch,
              callback: function($$v) {
                _vm.channelSearch = $$v
              },
              expression: "channelSearch"
            }
          }),
          _vm._v(" "),
          _c(
            "b-input-group-append",
            [
              _c(
                "b-dropdown",
                {
                  attrs: {
                    disabled: _vm.isBusy,
                    text:
                      _vm.channelStatusFilterOptions[
                        _vm.channelStatusFilterSelected
                      ].text,
                    variant: "outline-secondary",
                    right: ""
                  }
                },
                [
                  _c(
                    "b-dropdown-item-button",
                    {
                      attrs: { disabled: _vm.channelStatusFilterSelected == 0 },
                      on: {
                        click: function($event) {
                          _vm.channelStatusFilterSelected = 0
                        }
                      }
                    },
                    [
                      _vm._v(
                        "\n                    " +
                          _vm._s(_vm.channelStatusFilterOptions[0].text) +
                          "\n                "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "b-dropdown-item-button",
                    {
                      attrs: { disabled: _vm.channelStatusFilterSelected == 1 },
                      on: {
                        click: function($event) {
                          _vm.channelStatusFilterSelected = 1
                        }
                      }
                    },
                    [
                      _vm._v(
                        "\n                    " +
                          _vm._s(_vm.channelStatusFilterOptions[1].text) +
                          "\n                "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "b-dropdown-item-button",
                    {
                      attrs: { disabled: _vm.channelStatusFilterSelected == 2 },
                      on: {
                        click: function($event) {
                          _vm.channelStatusFilterSelected = 2
                        }
                      }
                    },
                    [
                      _vm._v(
                        "\n                    " +
                          _vm._s(_vm.channelStatusFilterOptions[2].text) +
                          "\n                "
                      )
                    ]
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "b-button",
                {
                  attrs: {
                    disabled:
                      !_vm.channelSearch && _vm.channelStatusFilterSelected == 0
                  },
                  on: {
                    click: function($event) {
                      _vm.channelSearch = ""
                      _vm.channelStatusFilterSelected = 0
                    }
                  }
                },
                [_c("i", { staticClass: "las la-fw la-times-circle" })]
              )
            ],
            1
          )
        ],
        1
      ),
      _vm._v(" "),
      _c("b-table", {
        attrs: {
          hover: "",
          "head-variant": "light",
          caption: "List of channels",
          busy: _vm.isBusy,
          items: _vm.channels,
          fields: _vm.channelTableFields,
          filter: _vm.channelFilter,
          "filter-function": _vm.filterChannelsTable,
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
                  { staticClass: "text-center text-primary my-2" },
                  [_c("b-spinner", { staticClass: "align-middle" })],
                  1
                )
              ]
            },
            proxy: true
          },
          {
            key: "cell(name)",
            fn: function(data) {
              return [
                _vm.getChannelAttribute(data.item, "logo")
                  ? _c("img", {
                      staticStyle: {
                        "max-width": "60%",
                        "max-height": "50px",
                        "margin-bottom": "5px",
                        filter: "drop-shadow(lightgray 1px 1px 1px)"
                      },
                      attrs: { src: _vm.getChannelAttribute(data.item, "logo") }
                    })
                  : _c(
                      "div",
                      {
                        staticClass: "guide-channel-name",
                        staticStyle: { "font-size": "0.9em", padding: "19px 0" }
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
                  _c("span", { staticStyle: { "font-size": "0.7em" } }, [
                    _vm._v(_vm._s(_vm.getChannelAttribute(data.item, "name")))
                  ])
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
                  staticClass: "form-control text-center mx-auto map-channel",
                  staticStyle: { "max-width": "250px" },
                  attrs: { type: "text" },
                  domProps: { value: data.item.mapped_channel_number },
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
                      "\n                " +
                        _vm._s(
                          data.item.channel_enabled ? "Enabled" : "Disabled"
                        ) +
                        "\n            "
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
                  "b-button",
                  {
                    staticClass: "text-center",
                    attrs: {
                      block: "",
                      variant: "link",
                      "aria-label": "Customize channel"
                    },
                    on: {
                      click: function($event) {
                        return _vm.$bvModal.show(data.item.id)
                      }
                    }
                  },
                  [_c("i", { staticClass: "las la-fw la-2x la-cog" })]
                ),
                _vm._v(" "),
                _c("channel-source-channel-modal", {
                  attrs: {
                    channel: data.item,
                    getChannelAttribute: _vm.getChannelAttribute,
                    saveChannel: _vm.saveChannel
                  }
                })
              ]
            }
          }
        ])
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/layouts/BlankLayout.vue?vue&type=template&id=44f0b5ea&":
/*!***********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/layouts/BlankLayout.vue?vue&type=template&id=44f0b5ea& ***!
  \***********************************************************************************************************************************************************************************************************/
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
  return _c("b-container", { attrs: { fluid: "" } }, [_vm._t("default")], 2)
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/layouts/MainLayout.vue?vue&type=template&id=5a6a1827&":
/*!**********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/layouts/MainLayout.vue?vue&type=template&id=5a6a1827& ***!
  \**********************************************************************************************************************************************************************************************************/
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
    "blank-layout",
    [
      _c("Navbar", { attrs: { items: _vm.navbarItems } }),
      _vm._v(" "),
      _vm._t("default")
    ],
    2
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var bootstrap__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.js");
/* harmony import */ var bootstrap__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(bootstrap__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var vue_meta__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-meta */ "./node_modules/vue-meta/dist/vue-meta.esm.js");
/* harmony import */ var v_tooltip__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! v-tooltip */ "./node_modules/v-tooltip/dist/v-tooltip.esm.js");
/* harmony import */ var bootstrap_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! bootstrap-vue */ "./node_modules/bootstrap-vue/esm/index.js");
/* harmony import */ var _inertiajs_inertia_vue__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @inertiajs/inertia-vue */ "./node_modules/@inertiajs/inertia-vue/dist/index.js");
/* harmony import */ var _inertiajs_inertia_vue__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_inertiajs_inertia_vue__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _inertiajs_progress__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @inertiajs/progress */ "./node_modules/@inertiajs/progress/dist/index.js");
/* harmony import */ var _inertiajs_progress__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_inertiajs_progress__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var ziggy_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ziggy-js */ "./node_modules/ziggy-js/dist/index.js");
/* harmony import */ var ziggy_js__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(ziggy_js__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _layouts_MainLayout_vue__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./layouts/MainLayout.vue */ "./resources/js/layouts/MainLayout.vue");
/* harmony import */ var bootstrap_dist_css_bootstrap_css__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! bootstrap/dist/css/bootstrap.css */ "./node_modules/bootstrap/dist/css/bootstrap.css");
/* harmony import */ var bootstrap_dist_css_bootstrap_css__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(bootstrap_dist_css_bootstrap_css__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var bootstrap_vue_dist_bootstrap_vue_css__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! bootstrap-vue/dist/bootstrap-vue.css */ "./node_modules/bootstrap-vue/dist/bootstrap-vue.css");
/* harmony import */ var bootstrap_vue_dist_bootstrap_vue_css__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(bootstrap_vue_dist_bootstrap_vue_css__WEBPACK_IMPORTED_MODULE_10__);
__webpack_require__(/*! ./bootstrap */ "./resources/js/bootstrap.js");












vue__WEBPACK_IMPORTED_MODULE_1___default.a.config.productionTip = false;
vue__WEBPACK_IMPORTED_MODULE_1___default.a.mixin({
  methods: {
    route: function route(name, params, absolute) {
      var config = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : Ziggy;
      return ziggy_js__WEBPACK_IMPORTED_MODULE_7___default()(name, params, absolute, config);
    }
  }
});
vue__WEBPACK_IMPORTED_MODULE_1___default.a.use(v_tooltip__WEBPACK_IMPORTED_MODULE_3__["default"]);
vue__WEBPACK_IMPORTED_MODULE_1___default.a.use(_inertiajs_inertia_vue__WEBPACK_IMPORTED_MODULE_5__["plugin"]);
vue__WEBPACK_IMPORTED_MODULE_1___default.a.use(vue_meta__WEBPACK_IMPORTED_MODULE_2__["default"]);
vue__WEBPACK_IMPORTED_MODULE_1___default.a.use(bootstrap_vue__WEBPACK_IMPORTED_MODULE_4__["BootstrapVue"]);
_inertiajs_progress__WEBPACK_IMPORTED_MODULE_6__["InertiaProgress"].init({
  showSpinner: true
}); // Register global components

var requireComponents = __webpack_require__("./resources/js/components sync recursive [A-Z]\\w+\\.(vue|js)$");

requireComponents.keys().forEach(function (component) {
  var componentConfig = requireComponents(component); // Get component name in PascalCase 

  var componentName = _.upperFirst(_.camelCase( // Gets the file name regardless of folder depth
  component.split('/').pop().replace(/\.\w+$/, ''))); // Register component with Vue


  vue__WEBPACK_IMPORTED_MODULE_1___default.a.component(componentName, componentConfig["default"] || componentConfig);
});
vue__WEBPACK_IMPORTED_MODULE_1___default.a.prototype.$router = 'fake';
var app = document.getElementById('app');
new vue__WEBPACK_IMPORTED_MODULE_1___default.a({
  metaInfo: {
    titleTemplate: function titleTemplate(title) {
      return title ? "".concat(title, " - ") + app_name : app_name;
    }
  },
  render: function render(h) {
    return h(_inertiajs_inertia_vue__WEBPACK_IMPORTED_MODULE_5__["App"], {
      props: {
        initialPage: JSON.parse(app.dataset.page),
        resolveComponent: function resolveComponent(name) {
          return __webpack_require__("./resources/js/pages lazy recursive ^\\.\\/.*$")("./".concat(name)).then(function (module) {
            if (!module["default"].layout) {
              module["default"].layout = _layouts_MainLayout_vue__WEBPACK_IMPORTED_MODULE_8__["default"];
            }

            return module["default"];
          });
        }
      }
    });
  }
}).$mount(app);

/***/ }),

/***/ "./resources/js/bootstrap.js":
/*!***********************************!*\
  !*** ./resources/js/bootstrap.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

window._ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'; // window.$ = window.jQuery = require('jquery');

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
// import Echo from 'laravel-echo';
// window.Pusher = require('pusher-js');
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

/***/ }),

/***/ "./resources/js/components sync recursive [A-Z]\\w+\\.(vue|js)$":
/*!**********************************************************!*\
  !*** ./resources/js/components sync [A-Z]\w+\.(vue|js)$ ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var map = {
	"./BInertiaLink.vue": "./resources/js/components/BInertiaLink.vue",
	"./Navbar.vue": "./resources/js/components/Navbar.vue",
	"./SourceProviderCard.vue": "./resources/js/components/SourceProviderCard.vue",
	"./channels/ChannelsTable.vue": "./resources/js/components/channels/ChannelsTable.vue",
	"./channels/ChannelsTableRow.vue": "./resources/js/components/channels/ChannelsTableRow.vue",
	"./channelsource/ChannelSourceChannelModal.vue": "./resources/js/components/channelsource/ChannelSourceChannelModal.vue",
	"./channelsource/ChannelSourceTable.vue": "./resources/js/components/channelsource/ChannelSourceTable.vue"
};


function webpackContext(req) {
	var id = webpackContextResolve(req);
	return __webpack_require__(id);
}
function webpackContextResolve(req) {
	if(!__webpack_require__.o(map, req)) {
		var e = new Error("Cannot find module '" + req + "'");
		e.code = 'MODULE_NOT_FOUND';
		throw e;
	}
	return map[req];
}
webpackContext.keys = function webpackContextKeys() {
	return Object.keys(map);
};
webpackContext.resolve = webpackContextResolve;
module.exports = webpackContext;
webpackContext.id = "./resources/js/components sync recursive [A-Z]\\w+\\.(vue|js)$";

/***/ }),

/***/ "./resources/js/components/BInertiaLink.vue":
/*!**************************************************!*\
  !*** ./resources/js/components/BInertiaLink.vue ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _BInertiaLink_vue_vue_type_template_id_1b0482fd___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./BInertiaLink.vue?vue&type=template&id=1b0482fd& */ "./resources/js/components/BInertiaLink.vue?vue&type=template&id=1b0482fd&");
/* harmony import */ var _BInertiaLink_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./BInertiaLink.vue?vue&type=script&lang=js& */ "./resources/js/components/BInertiaLink.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _BInertiaLink_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _BInertiaLink_vue_vue_type_template_id_1b0482fd___WEBPACK_IMPORTED_MODULE_0__["render"],
  _BInertiaLink_vue_vue_type_template_id_1b0482fd___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/BInertiaLink.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/BInertiaLink.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./resources/js/components/BInertiaLink.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_BInertiaLink_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./BInertiaLink.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/BInertiaLink.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_BInertiaLink_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/BInertiaLink.vue?vue&type=template&id=1b0482fd&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/BInertiaLink.vue?vue&type=template&id=1b0482fd& ***!
  \*********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_BInertiaLink_vue_vue_type_template_id_1b0482fd___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./BInertiaLink.vue?vue&type=template&id=1b0482fd& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/BInertiaLink.vue?vue&type=template&id=1b0482fd&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_BInertiaLink_vue_vue_type_template_id_1b0482fd___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_BInertiaLink_vue_vue_type_template_id_1b0482fd___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/Navbar.vue":
/*!********************************************!*\
  !*** ./resources/js/components/Navbar.vue ***!
  \********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Navbar_vue_vue_type_template_id_6dde423b___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Navbar.vue?vue&type=template&id=6dde423b& */ "./resources/js/components/Navbar.vue?vue&type=template&id=6dde423b&");
/* harmony import */ var _Navbar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Navbar.vue?vue&type=script&lang=js& */ "./resources/js/components/Navbar.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Navbar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Navbar_vue_vue_type_template_id_6dde423b___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Navbar_vue_vue_type_template_id_6dde423b___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Navbar.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Navbar.vue?vue&type=script&lang=js&":
/*!*********************************************************************!*\
  !*** ./resources/js/components/Navbar.vue?vue&type=script&lang=js& ***!
  \*********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Navbar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./Navbar.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Navbar.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Navbar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Navbar.vue?vue&type=template&id=6dde423b&":
/*!***************************************************************************!*\
  !*** ./resources/js/components/Navbar.vue?vue&type=template&id=6dde423b& ***!
  \***************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Navbar_vue_vue_type_template_id_6dde423b___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./Navbar.vue?vue&type=template&id=6dde423b& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Navbar.vue?vue&type=template&id=6dde423b&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Navbar_vue_vue_type_template_id_6dde423b___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Navbar_vue_vue_type_template_id_6dde423b___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/SourceProviderCard.vue":
/*!********************************************************!*\
  !*** ./resources/js/components/SourceProviderCard.vue ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _SourceProviderCard_vue_vue_type_template_id_4ab947f2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SourceProviderCard.vue?vue&type=template&id=4ab947f2& */ "./resources/js/components/SourceProviderCard.vue?vue&type=template&id=4ab947f2&");
/* harmony import */ var _SourceProviderCard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SourceProviderCard.vue?vue&type=script&lang=js& */ "./resources/js/components/SourceProviderCard.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _SourceProviderCard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _SourceProviderCard_vue_vue_type_template_id_4ab947f2___WEBPACK_IMPORTED_MODULE_0__["render"],
  _SourceProviderCard_vue_vue_type_template_id_4ab947f2___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/SourceProviderCard.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/SourceProviderCard.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/SourceProviderCard.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SourceProviderCard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./SourceProviderCard.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SourceProviderCard.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SourceProviderCard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/SourceProviderCard.vue?vue&type=template&id=4ab947f2&":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/SourceProviderCard.vue?vue&type=template&id=4ab947f2& ***!
  \***************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SourceProviderCard_vue_vue_type_template_id_4ab947f2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./SourceProviderCard.vue?vue&type=template&id=4ab947f2& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SourceProviderCard.vue?vue&type=template&id=4ab947f2&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SourceProviderCard_vue_vue_type_template_id_4ab947f2___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SourceProviderCard_vue_vue_type_template_id_4ab947f2___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/channels/ChannelsTable.vue":
/*!************************************************************!*\
  !*** ./resources/js/components/channels/ChannelsTable.vue ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ChannelsTable_vue_vue_type_template_id_21c70a4a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ChannelsTable.vue?vue&type=template&id=21c70a4a& */ "./resources/js/components/channels/ChannelsTable.vue?vue&type=template&id=21c70a4a&");
/* harmony import */ var _ChannelsTable_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ChannelsTable.vue?vue&type=script&lang=js& */ "./resources/js/components/channels/ChannelsTable.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ChannelsTable_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ChannelsTable_vue_vue_type_template_id_21c70a4a___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ChannelsTable_vue_vue_type_template_id_21c70a4a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/channels/ChannelsTable.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/channels/ChannelsTable.vue?vue&type=script&lang=js&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/channels/ChannelsTable.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ChannelsTable_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ChannelsTable.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/channels/ChannelsTable.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ChannelsTable_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/channels/ChannelsTable.vue?vue&type=template&id=21c70a4a&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/channels/ChannelsTable.vue?vue&type=template&id=21c70a4a& ***!
  \*******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ChannelsTable_vue_vue_type_template_id_21c70a4a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./ChannelsTable.vue?vue&type=template&id=21c70a4a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/channels/ChannelsTable.vue?vue&type=template&id=21c70a4a&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ChannelsTable_vue_vue_type_template_id_21c70a4a___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ChannelsTable_vue_vue_type_template_id_21c70a4a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/channels/ChannelsTableRow.vue":
/*!***************************************************************!*\
  !*** ./resources/js/components/channels/ChannelsTableRow.vue ***!
  \***************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ChannelsTableRow_vue_vue_type_template_id_1df9ba60___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ChannelsTableRow.vue?vue&type=template&id=1df9ba60& */ "./resources/js/components/channels/ChannelsTableRow.vue?vue&type=template&id=1df9ba60&");
/* harmony import */ var _ChannelsTableRow_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ChannelsTableRow.vue?vue&type=script&lang=js& */ "./resources/js/components/channels/ChannelsTableRow.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ChannelsTableRow_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ChannelsTableRow_vue_vue_type_template_id_1df9ba60___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ChannelsTableRow_vue_vue_type_template_id_1df9ba60___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/channels/ChannelsTableRow.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/channels/ChannelsTableRow.vue?vue&type=script&lang=js&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/channels/ChannelsTableRow.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ChannelsTableRow_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ChannelsTableRow.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/channels/ChannelsTableRow.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ChannelsTableRow_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/channels/ChannelsTableRow.vue?vue&type=template&id=1df9ba60&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/channels/ChannelsTableRow.vue?vue&type=template&id=1df9ba60& ***!
  \**********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ChannelsTableRow_vue_vue_type_template_id_1df9ba60___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./ChannelsTableRow.vue?vue&type=template&id=1df9ba60& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/channels/ChannelsTableRow.vue?vue&type=template&id=1df9ba60&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ChannelsTableRow_vue_vue_type_template_id_1df9ba60___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ChannelsTableRow_vue_vue_type_template_id_1df9ba60___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/channelsource/ChannelSourceChannelModal.vue":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/channelsource/ChannelSourceChannelModal.vue ***!
  \*****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ChannelSourceChannelModal_vue_vue_type_template_id_03a78908___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ChannelSourceChannelModal.vue?vue&type=template&id=03a78908& */ "./resources/js/components/channelsource/ChannelSourceChannelModal.vue?vue&type=template&id=03a78908&");
/* harmony import */ var _ChannelSourceChannelModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ChannelSourceChannelModal.vue?vue&type=script&lang=js& */ "./resources/js/components/channelsource/ChannelSourceChannelModal.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ChannelSourceChannelModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ChannelSourceChannelModal_vue_vue_type_template_id_03a78908___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ChannelSourceChannelModal_vue_vue_type_template_id_03a78908___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/channelsource/ChannelSourceChannelModal.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/channelsource/ChannelSourceChannelModal.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/channelsource/ChannelSourceChannelModal.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ChannelSourceChannelModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ChannelSourceChannelModal.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/channelsource/ChannelSourceChannelModal.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ChannelSourceChannelModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/channelsource/ChannelSourceChannelModal.vue?vue&type=template&id=03a78908&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/components/channelsource/ChannelSourceChannelModal.vue?vue&type=template&id=03a78908& ***!
  \************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ChannelSourceChannelModal_vue_vue_type_template_id_03a78908___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./ChannelSourceChannelModal.vue?vue&type=template&id=03a78908& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/channelsource/ChannelSourceChannelModal.vue?vue&type=template&id=03a78908&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ChannelSourceChannelModal_vue_vue_type_template_id_03a78908___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ChannelSourceChannelModal_vue_vue_type_template_id_03a78908___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/channelsource/ChannelSourceTable.vue":
/*!**********************************************************************!*\
  !*** ./resources/js/components/channelsource/ChannelSourceTable.vue ***!
  \**********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ChannelSourceTable_vue_vue_type_template_id_3b5b93a8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ChannelSourceTable.vue?vue&type=template&id=3b5b93a8& */ "./resources/js/components/channelsource/ChannelSourceTable.vue?vue&type=template&id=3b5b93a8&");
/* harmony import */ var _ChannelSourceTable_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ChannelSourceTable.vue?vue&type=script&lang=js& */ "./resources/js/components/channelsource/ChannelSourceTable.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ChannelSourceTable_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ChannelSourceTable_vue_vue_type_template_id_3b5b93a8___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ChannelSourceTable_vue_vue_type_template_id_3b5b93a8___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/channelsource/ChannelSourceTable.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/channelsource/ChannelSourceTable.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/channelsource/ChannelSourceTable.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ChannelSourceTable_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ChannelSourceTable.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/channelsource/ChannelSourceTable.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ChannelSourceTable_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/channelsource/ChannelSourceTable.vue?vue&type=template&id=3b5b93a8&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/channelsource/ChannelSourceTable.vue?vue&type=template&id=3b5b93a8& ***!
  \*****************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ChannelSourceTable_vue_vue_type_template_id_3b5b93a8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./ChannelSourceTable.vue?vue&type=template&id=3b5b93a8& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/channelsource/ChannelSourceTable.vue?vue&type=template&id=3b5b93a8&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ChannelSourceTable_vue_vue_type_template_id_3b5b93a8___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ChannelSourceTable_vue_vue_type_template_id_3b5b93a8___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/layouts/BlankLayout.vue":
/*!**********************************************!*\
  !*** ./resources/js/layouts/BlankLayout.vue ***!
  \**********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _BlankLayout_vue_vue_type_template_id_44f0b5ea___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./BlankLayout.vue?vue&type=template&id=44f0b5ea& */ "./resources/js/layouts/BlankLayout.vue?vue&type=template&id=44f0b5ea&");
/* harmony import */ var _BlankLayout_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./BlankLayout.vue?vue&type=script&lang=js& */ "./resources/js/layouts/BlankLayout.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _BlankLayout_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _BlankLayout_vue_vue_type_template_id_44f0b5ea___WEBPACK_IMPORTED_MODULE_0__["render"],
  _BlankLayout_vue_vue_type_template_id_44f0b5ea___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/layouts/BlankLayout.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/layouts/BlankLayout.vue?vue&type=script&lang=js&":
/*!***********************************************************************!*\
  !*** ./resources/js/layouts/BlankLayout.vue?vue&type=script&lang=js& ***!
  \***********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_BlankLayout_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./BlankLayout.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/layouts/BlankLayout.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_BlankLayout_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/layouts/BlankLayout.vue?vue&type=template&id=44f0b5ea&":
/*!*****************************************************************************!*\
  !*** ./resources/js/layouts/BlankLayout.vue?vue&type=template&id=44f0b5ea& ***!
  \*****************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_BlankLayout_vue_vue_type_template_id_44f0b5ea___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./BlankLayout.vue?vue&type=template&id=44f0b5ea& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/layouts/BlankLayout.vue?vue&type=template&id=44f0b5ea&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_BlankLayout_vue_vue_type_template_id_44f0b5ea___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_BlankLayout_vue_vue_type_template_id_44f0b5ea___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/layouts/MainLayout.vue":
/*!*********************************************!*\
  !*** ./resources/js/layouts/MainLayout.vue ***!
  \*********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _MainLayout_vue_vue_type_template_id_5a6a1827___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MainLayout.vue?vue&type=template&id=5a6a1827& */ "./resources/js/layouts/MainLayout.vue?vue&type=template&id=5a6a1827&");
/* harmony import */ var _MainLayout_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./MainLayout.vue?vue&type=script&lang=js& */ "./resources/js/layouts/MainLayout.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _MainLayout_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _MainLayout_vue_vue_type_template_id_5a6a1827___WEBPACK_IMPORTED_MODULE_0__["render"],
  _MainLayout_vue_vue_type_template_id_5a6a1827___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/layouts/MainLayout.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/layouts/MainLayout.vue?vue&type=script&lang=js&":
/*!**********************************************************************!*\
  !*** ./resources/js/layouts/MainLayout.vue?vue&type=script&lang=js& ***!
  \**********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MainLayout_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./MainLayout.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/layouts/MainLayout.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MainLayout_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/layouts/MainLayout.vue?vue&type=template&id=5a6a1827&":
/*!****************************************************************************!*\
  !*** ./resources/js/layouts/MainLayout.vue?vue&type=template&id=5a6a1827& ***!
  \****************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MainLayout_vue_vue_type_template_id_5a6a1827___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./MainLayout.vue?vue&type=template&id=5a6a1827& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/layouts/MainLayout.vue?vue&type=template&id=5a6a1827&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MainLayout_vue_vue_type_template_id_5a6a1827___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MainLayout_vue_vue_type_template_id_5a6a1827___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/pages lazy recursive ^\\.\\/.*$":
/*!***********************************************************!*\
  !*** ./resources/js/pages lazy ^\.\/.*$ namespace object ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var map = {
	"./Home": [
		"./resources/js/pages/Home.vue",
		"Home"
	],
	"./Home.vue": [
		"./resources/js/pages/Home.vue",
		"Home"
	],
	"./Log": [
		"./resources/js/pages/Log.vue",
		"Log"
	],
	"./Log.vue": [
		"./resources/js/pages/Log.vue",
		"Log"
	],
	"./channels/Remap": [
		"./resources/js/pages/channels/Remap.vue",
		"channels-Remap"
	],
	"./channels/Remap.vue": [
		"./resources/js/pages/channels/Remap.vue",
		"channels-Remap"
	],
	"./channelsource/Map": [
		"./resources/js/pages/channelsource/Map.vue",
		"channelsource-Map"
	],
	"./channelsource/Map.vue": [
		"./resources/js/pages/channelsource/Map.vue",
		"channelsource-Map"
	]
};
function webpackAsyncContext(req) {
	if(!__webpack_require__.o(map, req)) {
		return Promise.resolve().then(function() {
			var e = new Error("Cannot find module '" + req + "'");
			e.code = 'MODULE_NOT_FOUND';
			throw e;
		});
	}

	var ids = map[req], id = ids[0];
	return __webpack_require__.e(ids[1]).then(function() {
		return __webpack_require__(id);
	});
}
webpackAsyncContext.keys = function webpackAsyncContextKeys() {
	return Object.keys(map);
};
webpackAsyncContext.id = "./resources/js/pages lazy recursive ^\\.\\/.*$";
module.exports = webpackAsyncContext;

/***/ }),

/***/ 0:
/*!***********************************!*\
  !*** multi ./resources/js/app.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/avolin/Projects/PHP/Personal/Laravel/channels-buddy/resources/js/app.js */"./resources/js/app.js");


/***/ })

},[[0,"/js/manifest","/js/vendor"]]]);