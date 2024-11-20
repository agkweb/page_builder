$(document).ready(function () {
  // const projectId = getProjectId();
  var editor = grapesjs.init({
    fromElement: 1,
    container: "#gjs",
    allowScripts: 1,
    forceClass: false,
    storageManager: 0,
      assetManager: {
          upload: 'http://localhost:8000/pages/upload/images',
          uploadName: 'files',
          multiUpload: true,
          autoAdd: true,
          assets: [
                  // 'http://localhost:8000/upload/images/11.jpg',
          ],
      },



    // storageManager: {
    //   type: 0, // Storage type. Available: local | remote
    //   type: "local", // Storage type. Available: local | remote
    //   autosave: true, // Store data automatically
    //   // autoload: true, // Autoload stored data on init
    //   stepsBeforeSave: 1, // If autosave is enabled, indicates how many changes are necessary before the store method is triggered
    //   // ...
    //   // Default storage options
    //   options: {
    //     local: {
    //       /* ... */
    //     },
    //     remote: {
    //       /* ... */
    //     },
    //   },
    // },
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
            "flex-direction",
                    "flex-wrap",
                    "justify-content",
                    "align-items",
                    "align-content",
                    "order",
                    "flex-basis",
                    "flex-grow",
                    "flex-shrink",
                    "align-self",
            {
              name: "فعال کردن انعطاف پذیری",
              property: "display",
              type: "select",
              defaults: "flex",
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
  // editor.Panels.removeButton('options', 'export-template');
  // editor.Panels.addButton({id: "export-template", className: "fa fa-download"});
  // editor.Panels.getButton()
  editor.Panels.getButton("options", "export-template").set("className", "fa fa-download")



  // editor.Panels.removeButton('options', 'preview');
  editor.Panels.removeButton('options', 'gjs-open-import-webpage');

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


  editor.Commands.add("export-template", {
    run: (editor) => {
      document.getElementById("html").value = editor.getHtml();
      document.getElementById("css").value = editor.getCss();
      $('#pageData').submit();

      // const exportData = {
        // document.getElementById("html").val = editor.getHtml(),
      //   css: editor.getCss(),
      // };
      // console.log("exportData :>>", exportData)
    },

  })

  editor.Panels.removePanel("views");
  window.editor = editor;

  // const cssCode = editor.getCss();
  // const htmlCode = editor.getHtml();

  // // Get current project data
  // const projectData = editor.getProjectData();
  // // Load project data
  // editor.loadProjectData(projectData);
  //
  // // Store data
  // const storedProjectData = editor.store();
  //
  // // Load data
  // const loadedProjectData = editor.load();
  // console.log(projectData);
  //
  //
  // const amConfig = editor.AssetManager.getConfig();
  //
  // console.log(amConfig);
    setTimeout(() => {
        const htmlCode = document.getElementById("html").value;
        const cssCode = document.getElementById("css").value
        editor.setComponents(htmlCode);
        editor.setStyle(cssCode);
    }, 1);
    // Add the block to the block manager
    editor.BlockManager.add('twoStepFormBlock', {
        id: 'two-step-form',
        label: 'Two Step Form',
        content: `
            <div class="form-step-1" style="background: #0b2e13">
                <h2>Step 1: Personal Information</h2>
                <form class="form-step-1">
                    <label for="name">Name:</label>
                    <input type="hidden" id="page_id" name="page_id">
                    <input type="tel" id="phone_number" name="phone_number" placeholder="09123456789" required>
                    <button type="button" id="nextForm">Next</button>
                </form>
            </div>
            <div class="form-step-2">
                <h2>Step 2: Contact Information</h2>
                <form id="form-step-2" action="http://localhost:8000/registrations/storeData" method="get">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    <input type="text" id="field" name="field" required>
                    <input type="hidden" id="form_2_phone_number" name="form_2_phone_number" required>
                    <input type="hidden" id="form_2_page_id" name="form_2_page_id" required>
                    <button type="submit">Submit</button>
                </form>
            </div>
            `
    });
});
