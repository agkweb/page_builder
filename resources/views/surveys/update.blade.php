<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- cdn -->
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/lib/popper.min.js"></script>
    <link rel="stylesheet" href="/css/grapes.min.css">
    <script src="/js/jquery.min.js"></script>
    <script src="/js/grapesjs.min.js"></script>
    <script src="/js/grapesjs-blocks-basic.js"></script>
    <script src="/js/grapesjs-plugin-forms.js"></script>
    <script src="/js/index.min.js"></script>
    <script src="/js/micromodal.min.js"></script>
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet" /> -->
    <!-- <script src="js/bootstrap.min.js"></script> -->

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
    <!-- custom -->

    <link rel="stylesheet" href="/css/sepectre.min.css">
    <link rel="stylesheet" href="/css/spectre-exp.min.css">

    <link rel="stylesheet" href="/css/modal.css">
    <link rel="stylesheet" href="/css/custom.css">
    <script src="/js/gjs.blocks.js"></script>
    <script src="/js/gjs.traits.js"></script>
    <script src="/js/gjs.components.js"></script>
    <script src="/js/gjs.commands.js"></script>
    <script src="/js/gjs.rte.js"></script>
    <script src="/js/custom.js"></script>
</head>
<body>
<form action="{{ route('pages.update', ['page' => $page]) }}" id="pageData" method="POST" style="display: none;">
    @csrf
    @method('put')
    <input type="text" name="title" id="title" value="{{ $page->page_id }}">
    <input type="text" name="title" id="title" value="{{ $page->title }}">
    <input type="text" name="category_id" id="category_id" value="{{ $page->category_id }}">
    <input type="text" name="is_active" id="is_active" value="{{ $page->is_active }}">

    <textarea name="html" id="html">
        {{ $page->html }}
    </textarea>
    <textarea name="css" id="css">
        {{ $page->css }}
    </textarea>
</form>

<div class="row" style="height:100%">
    <!-- <div class="modal-dialog">
       <div class="modal-content" style="direction: rtl;">
         <form id="create-page" novalidate onsubmit="return validateForm(event)">
           <div class="modal-header">
             <h5 class="modal-title" id="addPageModalLabel"> ایجاد صفحه</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close" style="margin-left: 0;"
               onclick="clearForm()"></button>
           </div>
           <div class="modal-body">
             <div class="col-auto">
               <label class="form-label" for="name">نام صفحه را وارد کنید</label>
               <input type="text" name="name" id="name" class="form-control form-control-sm" placeholder="اسم صفحه"
                 required />
               <div class="invalid-feedback">
                 لطفا یک نام معتبر وارد کنید
               </div>
             </div>
           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"
               onclick="clearForm()">بستن</button>
             <button type="submit" class="btn btn-primary btn-sm">ذخیره</button>
           </div>
         </form>
       </div>
     </div> -->
    <div class="column editor-clm">
        <!-- <h2>Modal Example</h2> -->
        <!-- Trigger the modal with a button -->
        <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->

        <!-- Modal -->
        <!-- <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog"> -->

        <!-- Modal content-->
        <!-- <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Modal Header</h4>
          </div>
          <div class="modal-body">
            <p>Some text in the modal.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div> -->
        <!--
            </div>
          </div> -->


        <div id="gjs">


            <!-- <div class="panel">
              <h1 class="welcome">Welcome to</h1>
              <div class="big-title">
                <svg class="logo" viewBox="0 0 100 100">
                  <path d="M40 5l-12.9 7.4 -12.9 7.4c-1.4 0.8-2.7 2.3-3.7 3.9 -0.9 1.6-1.5 3.5-1.5 5.1v14.9 14.9c0 1.7 0.6 3.5 1.5 5.1 0.9 1.6 2.2 3.1 3.7 3.9l12.9 7.4 12.9 7.4c1.4 0.8 3.3 1.2 5.2 1.2 1.9 0 3.8-0.4 5.2-1.2l12.9-7.4 12.9-7.4c1.4-0.8 2.7-2.2 3.7-3.9 0.9-1.6 1.5-3.5 1.5-5.1v-14.9 -12.7c0-4.6-3.8-6-6.8-4.2l-28 16.2"/>
                </svg>
                <span>GrapesJS</span>
              </div>
              <div class="description">
                This is a demo content from index.html. For the development, you shouldn't edit this file, instead you can
                copy and rename it to _index.html, on next server start the new file will be served, and it will be ignored by git.
              </div>
            </div> -->
            <style>
                .panel {
                    width: 90%;
                    max-width: 700px;
                    border-radius: 3px;
                    padding: 30px 20px;
                    margin: 150px auto 0px;
                    background-color: #d983a6;
                    box-shadow: 0px 3px 10px 0px rgba(0,0,0,0.25);
                    color:rgba(255,255,255,0.75);
                    font: caption;
                    font-weight: 100;
                }

                .welcome {
                    text-align: center;
                    font-weight: 100;
                    margin: 0px;
                }

                .logo {
                    width: 70px;
                    height: 70px;
                    vertical-align: middle;
                }

                .logo path {
                    pointer-events: none;
                    fill: none;
                    stroke-linecap: round;
                    stroke-width: 7;
                    stroke: #fff
                }

                .big-title {
                    text-align: center;
                    font-size: 3.5rem;
                    margin: 15px 0;
                }

                .description {
                    text-align: justify;
                    font-size: 1rem;
                    line-height: 1.5rem;
                }

            </style>
        </div>
    </div>
    <div id="style-manager" class="column" style="flex-basis: 500px">
        <ul class="tab tab-block">
            <li class="tab-item active" data-panel-type="content">
                <a href="#">ویژگی</a>
            </li>
            <li class="tab-item" data-panel-type="styles">
                <a href="#">استایل دهی</a>
            </li>
        </ul>
        <div id="content" class="tab-content">
            <div id="blocks"></div>
        </div>
        <div id="styles" class="tab-content" style="display:none;">
            <div id="selectors-container"></div>
            <div id="traits-container"></div>
            <div id="style-manager-container"></div>
            <div class="modal fade" id="addPageModal" tabindex="-1" aria-labelledby="addPageModalLabel" aria-hidden="true"
                 data-bs-backdrop="static" data-bs-keyboard="false">
                <!-- <div class="modal-dialog">
                  <div class="modal-content" style="direction: rtl;">
                    <form id="create-page" novalidate onsubmit="return validateForm(event)">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addPageModalLabel"> ایجاد صفحه</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close" style="margin-left: 0;"
                          onclick="clearForm()"></button>
                      </div>
                      <div class="modal-body">
                        <div class="col-auto">
                          <label class="form-label" for="name">نام صفحه را وارد کنید</label>
                          <input type="text" name="name" id="name" class="form-control form-control-sm" placeholder="اسم صفحه"
                            required />
                          <div class="invalid-feedback">
                            لطفا یک نام معتبر وارد کنید
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"
                          onclick="clearForm()">بستن</button>
                        <button type="submit" class="btn btn-primary btn-sm">ذخیره</button>
                      </div>
                    </form>
                  </div>
                </div> -->

            </div>
        </div>

    </div>

    <!-- Modal https://micromodal.vercel.app/ -->
    <!-- Open using MicroModal.show('modal-1'); -->

    <div class="modal micromodal-slide" id="modal-1" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                <header class="modal__header">
                    <h2 class="modal__title" id="modal-1-title">
                        Micromodal
                    </h2>
                    <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content" id="modal-1-content">
                    <p>
                        Try hitting the <code>tab</code> key and notice how the focus stays within the modal itself. Also, <code>esc</code> to close modal.
                    </p>
                </main>
                <footer class="modal__footer">
                    <button class="modal__btn modal__btn-primary">Continue</button>
                    <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">Close</button>
                </footer>
            </div>
        </div>
    </div>
    <script src="/js/gjs.init.js"></script>
</div>
</body>
</html>
