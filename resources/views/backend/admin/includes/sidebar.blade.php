<!-- partial:partials/_sidebar.html -->
<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ url('/') }}" class="sidebar-brand">
            Soft<span>Vence</span>
        </a>
        <div class="sidebar-toggler ">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Admin</li>
            <!--  Dashboard  -->
            <li class="nav-item {{ $data['active_menu'] == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link ">
                    <i class="fa-solid fa-chart-line"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>

                  {{-- category --}}
            <li class="nav-item {{ $data['active_menu'] == 'category_list' ? 'active' : '' }}">
                <a href="{{ route('admin.category.list') }}" class="nav-link ">
                    <i class="fa-solid fa-list"></i>
                    <span class="link-title">Category</span>
                </a>
            </li>
            <li
                class="nav-item {{ $data['active_menu'] == 'course_add' || $data['active_menu'] == 'course_edit' || $data['active_menu'] == 'course_list' ||$data['active_menu']=='course_syllabus_list' || $data['active_menu']== 'course_syllabus_add' ? 'active' : '' }}">
                <a class="nav-link" data-bs-toggle="collapse" href="#course" role="button" aria-expanded="false"
                    aria-controls="course">
                    <i class="fa-solid fa-book-open"></i>
                    <span class="link-title">Courses Manage</span>
                    <i class="fa-solid fa-chevron-down link-arrow"></i>
                </a>
                <div class="collapse" id="course">
                    <ul class="nav sub-menu">
                        <li class="nav-item ">
                            <a href="{{ route('admin.course.add') }}"
                                class="nav-link {{ $data['active_menu'] == 'course_add' ? 'active' : '' }}">Course
                                Add</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.course.list') }}"
                                class="nav-link {{ $data['active_menu'] == 'course_list' ? 'active' : '' }}">Course
                                List</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>

<!-- partial -->
