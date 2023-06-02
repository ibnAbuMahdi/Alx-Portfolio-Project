<aside>

    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- <li class="nav-heading">Pages</li> -->

        <li class="nav-item">
            <a class="nav-link " data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Students</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="<?php echo site_url('admin/userdata'); ?>">
                        <i class="bi bi-circle"></i><span>Admission</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " data-bs-target="#students-nav" data-bs-toggle="collapse" href="<?php echo site_url("admin/get_student"); ?>">
                    <i class="bi bi-circle"></i><span>Student List</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id = students-nav class = "nav-content collapse" data-bs-parent="#components-nav">
                        <li>
                            <a href="<?php echo site_url("admin/get_student/All"); ?>">
                                <i class="bi bi-circle"></i><span style='color:red'>All</span>
                            </a> 
                        </li>
                        <li>
                            <a href="<?php echo site_url("admin/get_student/Nursery"); ?>">
                                <i class="bi bi-circle"></i><span style='color:red'>Nursery</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url("admin/get_student/Primary"); ?>">
                                <i class="bi bi-circle"></i><span style='color:red'>Primary</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url("admin/get_student/SS"); ?>">
                                <i class="bi bi-circle"></i><span style='color:red'>Secondary</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo site_url("admin/select_id_card"); ?>">
                        <i class="bi bi-circle"></i><span>ID Cards</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url("admin/result_form"); ?>">
                        <i class="bi bi-circle"></i><span>Results</span>
                    </a>
                </li>
                <li>
                    <a  href="<?php echo site_url("admin/to_promote"); ?>">
                        <i class="bi bi-circle"></i><span>Promotion</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->
       
    </ul>

</aside><!-- End Sidebar-->