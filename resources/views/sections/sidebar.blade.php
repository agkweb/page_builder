<div class="sidebar" style="text-align: right;">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}"><i class="icon-speedometer"></i> داشبورد <span class="tag tag-info"></span></a>
            </li>

            <li class="nav-title">
                مدیریت دسته بندی ها
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $active == 'createCategory' ? 'active' : '' }}" href="{{ route('categories.create') }}"><i class="icon-tag"></i> ثبت دسته بندی</a>
                <a class="nav-link {{ $active == 'indexCategory' ? 'active' : '' }}" href="{{ route('categories.index') }}"><i class="icon-list"></i> لیست دسته بندی ها</a>
            </li>

            <li class="nav-title">
                مدیریت صفحات
            </li>
            <li class="nav-item">
{{--                <a class="nav-link {{ $active == 'createPage' ? 'active' : '' }}" href="{{ route('pages.create') }}"><i class="icon-tag"></i> ثبت صفحه</a>--}}
                <a class="nav-link {{ $active == 'indexPage' ? 'active' : '' }}" href="{{ route('pages.index') }}"><i class="icon-list"></i> لیست صفحات</a>
            </li>

            <li class="nav-title">
                مدیریت ثبت نامی ها
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $active == 'indexRegistrations' ? 'active' : '' }}" href="{{ route('registrations.index') }}"><i class="icon-list"></i> لیست ثبت نامی ها</a>
            </li>

            <li class="nav-title">
                مدیریت پرسش نامه ها
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $active == 'indexSurveys' ? 'active' : '' }}" href="{{ route('surveys.index') }}"><i class="icon-list"></i> لیست پرسش نامه ها</a>
            </li>

            <li class="nav-title">
                مدیریت آزمون ها
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $active == 'indexQuizzes' ? 'active' : '' }}" href="{{ route('quizzes.index') }}"><i class="icon-list"></i> لیست آزمون ها</a>
            </li>
        </ul>
    </nav>
</div>
