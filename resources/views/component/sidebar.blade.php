<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <img src="{{ asset('assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">@stack('side_head')</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if(auth()->user()?->role === \App\Models\User::ROLE_ADMIN)
                    <li class="nav-item">
                        <a href="{{ route('admin.students.index') }}" class="nav-link">
                            <i class="nav-icon bi bi-people"></i>
                            <p>Students</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.teachers.index') }}" class="nav-link">
                            <i class="nav-icon bi bi-person-badge"></i>
                            <p>Teachers</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.exam-categories.index') }}" class="nav-link">
                            <i class="nav-icon bi bi-tags"></i>
                            <p>Exam Categories</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.exams.index') }}" class="nav-link">
                            <i class="nav-icon bi bi-journal-text"></i>
                            <p>Exams</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.exam-admissions.index') }}" class="nav-link">
                            <i class="nav-icon bi bi-file-earmark-check"></i>
                            <p>Admissions</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.results.index') }}" class="nav-link"> 
                            <i class="nav-icon bi bi-clipboard-data"></i>
                            <p>Results</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.class-rooms.index') }}" class="nav-link">
                        <i class="nav-icon bi bi-easel"></i>
                            <p>Classes</p>
                        </a>
                    </li>
                    <li class="nav-item"></li>
                        <a href="{{ route('admin.attendance.index') }}" class="nav-link"> 
                            <i class="nav-icon bi bi-calendar2-check"></i>
                            <p>Attendance</p>
                        </a>
                    </li>
                @endif

            

                @if(auth()->user()?->role === \App\Models\User::ROLE_TEACHER)
                    <li class="nav-item">
                        <a href="{{ route('teacher.profile.edit') }}" class="nav-link"> 
                            <i class="nav-icon bi bi-person-lines-fill"></i>
                            <p>Edit My Profile</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('teacher.classes.index') }}" class="nav-link"> 
                            <i class="nav-icon bi bi-people"></i>
                            <p>My Classes</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('teacher.exams.index') }}" class="nav-link"> 
                            <i class="nav-icon bi bi-clipboard-check"></i>
                            <p>My Exams</p>
                        </a>
                    </li>
                @endif

                @if(auth()->user()?->role === \App\Models\User::ROLE_STUDENT)
                    <li class="nav-item">
                        <a href="{{ route('student.profile.edit') }}" class="nav-link"> 
                            <i class="nav-icon bi bi-person-lines-fill"></i>
                            <p>Edit My Details</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('student.exam-admission.create') }}" class="nav-link"> 
                            <i class="nav-icon bi bi-file-earmark-plus"></i>
                            <p>Exam Admission</p>
                        </a>
                    </li>
                @endif
            </ul>

            <div class="px-3 mt-3 d-grid gap-2">
                <!-- @if(auth()->user()?->role === \App\Models\User::ROLE_ADMIN)
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="themeToggleBtn">Toggle Dark Mode</button>
                @endif -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm w-100">Logout</button>
                </form>
            </div>
        </nav>
    </div>
</aside>
