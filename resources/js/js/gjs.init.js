$(document).ready(function () {
  var editor = grapesjs.init({
    fromElement: 1,
    container: "#gjs",
    allowScripts: 1,
    forceClass: false,
    storageManager: {
      type: 0, // Storage type. Available: local | remote
    },
    canvas: {
      styles: ["css/canvas.css"],
      scripts: [],
    },
    canvasCss: `
    .gjs-selected {
      outline: 2px solid #000 !important;
    }
    `,
    blockManager: {
      appendTo: "#blocks",
    },
    // styleManager: {
    //   appendTo: '#style-manager-container'
    // },
    styleManager: {
      appendTo: "#style-manager-container",
      sectors: [
        {
          name: "خصوصیات",
          open: false,
          buildProps: ["width", "min-height", "padding", "height", "margin"],
          properties: [
            {
              type: "integer",
              name: "عرض",
              property: "width",
              units: ["px", "%", "rem"],
              defaults: "100",
              min: 0,
            },
            {
              type: "integer",
              name: "ارتفاع",
              property: "min-height",
              units: ["px", "%", "rem"],
              defaults: "auto",
              min: 0,
            },
            {
              type: "composite",
              name: "فاصله از اطراف",
              property: "padding",
              properties: [
                {
                  name: "بالا",
                  property: "padding-top",
                  type: "integer",
                  units: ["px", "%", "em"],
                },
                {
                  name: "راست",
                  property: "padding-right",
                  type: "integer",
                  units: ["px", "%", "em"],
                },
                {
                  name: "پایین",
                  property: "padding-bottom",
                  type: "integer",
                  units: ["px", "%", "em"],
                },
                {
                  name: "چپ",
                  property: "padding-left",
                  type: "integer",
                  units: ["px", "%", "em"],
                },
              ],
              units: ["px", "%", "rem"],
              defaults: "0",
              min: 0,
            },
            {
              type: "composite",
              name: "فاصله از عضو دیگر",
              property: "margin",
              properties: [
                {
                  name: "بالا",
                  property: "margin-top",
                  type: "integer",
                  units: ["px", "%", "em"],
                  default: "0",
                },
                {
                  name: "راست",
                  property: "margin-right",
                  type: "integer",
                  units: ["px", "%", "em"],
                  default: "0",
                },
                {
                  name: "پایین",
                  property: "margin-bottom",
                  type: "integer",
                  units: ["px", "%", "em"],
                  default: "0",
                },
                {
                  name: "چپ",
                  property: "margin-left",
                  type: "integer",
                  units: ["px", "%", "em"],
                  default: "0",
                },
              ],
              units: ["px", "%", "rem"],
              // defaults: "0",
              min: 0,
            },
          ],
        },
        {
          name: "تایپوگرافی",
          open: false,
          buildProps: [
            "font-family",
            "font-size",
            "font-weight",
            "letter-spacing",
            "color",
            "line-height",
            "text-align",
            "text-shadow",
          ],
          properties: [
            {
              property: "text-align",
              defaults: "left",
              name: "تراز کردن متن",
              list: [
                {
                  value: "left",
                  name: "چپ",
                  className: "fa fa-align-left",
                  label: "چپ",
                },
                {
                  value: "center",
                  name: "مرکز",
                  className: "fa fa-align-center",
                  label: "مرکز",
                },
                {
                  value: "right",
                  name: "راست",
                  className: "fa fa-align-right",
                  label: "راست",
                },
                {
                  value: "justify",
                  name: "جاستیفای",
                  className: "fa fa-align-justify",
                  label: "جاستیفای",
                },
              ],
            },
          ],
        },
        {
          name: "تزئینات",
          open: !1,
          properties: [
            "background-color",
            "border-radius",
            "border",
            "box-shadow",
            "background",
          ],
        },
        {
          name: "اضافه",
          open: !1,
          properties: ["opacity"],
          // properties: ["opacity", "transition", "transform"],
        },
        {
          name: "انعطاف پذیری",
          open: false,
          properties: [
            {
              name: "فعال کردن انعطاف پذیری",
              property: "display",
              type: "select",
              defaults: "block",
              list: [
                { value: "block", name: "Disable" },
                { value: "flex", name: "Enable" },
              ],
            },
            // {
            //   name: 'Flex Parent',
            //   property: 'label-parent-flex',
            //   type: 'integer',
            // },
            // {
            //   name: 'Direction',
            //   property: 'flex-direction',
            //   type: 'radio',
            //   defaults: 'row',
            //   list: [
            //     {
            //       value: 'row',
            //       name: 'Row',
            //       className: 'icons-flex icon-dir-row',
            //       title: 'Row',
            //     },
            //     {
            //       value: 'row-reverse',
            //       name: 'Row reverse',
            //       className: 'icons-flex icon-dir-row-rev',
            //       title: 'Row reverse',
            //     },
            //     {
            //       value: 'column',
            //       name: 'Column',
            //       title: 'Column',
            //       className: 'icons-flex icon-dir-col',
            //     },
            //     {
            //       value: 'column-reverse',
            //       name: 'Column reverse',
            //       title: 'Column reverse',
            //       className: 'icons-flex icon-dir-col-rev',
            //     }
            //   ],
            // },
            {
              name: "تراز افقی",
              label: "جاستیفای",
              property: "justify-content",
              type: "radio",
              defaults: "flex-start",
              list: [
                {
                  value: "flex-start",
                  className: "fa fa-align-left",
                  title: "Start",
                },
                {
                  value: "flex-end",
                  title: "End",
                  className: "fa fa-align-right",
                },
                {
                  value: "space-between",
                  title: "Space between",
                  className: "fa fa-align-right",
                },
                {
                  value: "space-around",
                  title: "Space around",
                  className: "fa fa-align-left",
                },
                {
                  value: "center",
                  title: "Center",
                  className: "fa fa-align-center",
                },
              ],
            },
            {
              name: "تراز عمودی",
              property: "align-items",
              type: "radio",
              defaults: "center",
              list: [
                {
                  value: "flex-start",
                  title: "Start",
                  className: "fa fa-align-left",
                },
                {
                  value: "flex-end",
                  title: "End",
                  className: "fa fa-align-right",
                },
                // {
                //   value: 'stretch',
                //   title: 'Stretch',
                //   className: 'icons-flex icon-al-str',
                // },
                {
                  value: "center",
                  title: "Center",
                  className: "fa fa-align-center",
                },
              ],
            },
            // {
            //   name: 'Flex Children',
            //   property: 'label-parent-flex',
            //   type: 'integer',
            // },
            // {
            //   name: 'Order',
            //   property: 'order',
            //   type: 'integer',
            //   defaults: 0,
            //   min: 0
            // },
            // {
            //   name: 'Flex',
            //   property: 'flex',
            //   type: 'composite',
            //   properties: [
            //     {
            //       name: 'Grow',
            //       property: 'flex-grow',
            //       type: 'integer',
            //       defaults: 0,
            //       min: 0
            //     },
            //     {
            //       name: 'Shrink',
            //       property: 'flex-shrink',
            //       type: 'integer',
            //       defaults: 0,
            //       min: 0
            //     },
            //     {
            //       name: 'Basis',
            //       property: 'flex-basis',
            //       type: 'integer',
            //       units: ['px', '%', ''],
            //       unit: '',
            //       defaults: 'auto',
            //     }
            //   ],
            // },
            // {
            //   name: 'Align',
            //   property: 'align-self',
            //   type: 'radio',
            //   defaults: 'auto',
            //   list: [
            //     {
            //       value: 'auto',
            //       name: 'Auto',
            //     },
            //     {
            //       value: 'flex-start',
            //       title: 'Start',
            //       className: 'icons-flex icon-al-start',
            //     },
            //     {
            //       value: 'flex-end',
            //       title: 'End',
            //       className: 'icons-flex icon-al-end',
            //     },
            //     {
            //       value: 'stretch',
            //       title: 'Stretch',
            //       className: 'icons-flex icon-al-str',
            //     },
            //     {
            //       value: 'center',
            //       title: 'Center',
            //       className: 'icons-flex icon-al-center',
            //     }
            //   ],
            // }
          ],
        },
      ],
    },
    traitManager: {
      appendTo: "#traits-container",
    },
    plugins: [
      "gjs-blocks-basic",
      "grapesjs-preset-webpage",
      "grapesjs-plugin-forms",
      Traits,
      Component,
      Blocks,
      Commands,
      RTE,
    ],
    pluginsOpts: {
      "grapesjs-preset-webpage": {},
      "gjs-blocks-basic": {},
      "grapesjs-plugin-forms": {},
    },
  });
  editor.Panels.getButton("options", "sw-visibility").set("active", false);
  editor.Panels.getButton("views", "open-blocks").set("active", true);
  //editor.Panels.removeButton('options', 'export-template');
  editor.Panels.removeButton("options", "fullscreen");
  // editor.Panels.removeButton('options', 'preview');
  //editor.Panels.removeButton('options', 'gjs-open-import-webpage');

  //remove uneeded body wrapper from mjml
  editor.getWrapper().toHTML = function (opts) {
    return this.getInnerHTML(opts);
  };

  //open style manager once block is dropped or clicked
  editor.on("block:drag:stop, component:selected", function (model) {
    let tagName = model?.attributes?.tagName;
    if (tagName && tagName != "mj-section") {
      window.openPanel("styles");
    }
  });

  //prevent janky rendering
  editor.on("load", function () {
    document.getElementById("gjs").style.display = "block";
  });

  setTimeout(() => {
    // Collapsed Category in Blocks
    const categories = editor.BlockManager.getCategories();
    categories.each((category) => {
      category.set("open", false).on("change:open", (opened) => {
        opened.get("open") &&
          categories.each((category) => {
            category !== opened && category.set("open", false);
          });
      });
    });
  }, 100);

  editor.Panels.removePanel("views");
  window.editor = editor;
});
