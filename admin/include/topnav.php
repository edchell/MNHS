<div class="header">
    <div class="header-left">
        <div class="menu-icon bi bi-list" style="color:white;"></div>
        <div class="header-search">
        </div>
    </div>
    <div class="header-right">
        <div class="dashboard-setting user-notification">
            <div class="dropdown">
            </div>
        </div>
        <div class="user-notification">
            <!-- Notification dropdown code can go here -->
        </div>
        <div class="user-info-dropdown">
            <div class="dropdown">
                <a
                    class="dropdown-toggle"
                    href="#"
                    role="button"
                    data-toggle="dropdown"
                    style="color:white;"
                >
                    <span class="user-icon">
                        <img src="vendors/images/photo1.jpg" alt="" />
                    </span>
                    <span class="user-name text-white">
                        <?php 
                        // Display the user's first and last name
                        echo isset($_SESSION['FIRSTNAME']) && isset($_SESSION['LASTNAME']) ? $_SESSION['FIRSTNAME'] . ' ' . $_SESSION['LASTNAME'] : 'Guest'; 
                        ?>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                    <a class="dropdown-item" href="profile.html">
                        <i class="dw dw-user1"></i> Profile
                    </a>
                    <a class="dropdown-item" href="../logout.php"> <!-- Redirect to logout script -->
                        <i class="dw dw-logout"></i> Log Out
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="right-sidebar">
    <div class="right-sidebar-body customscroll">
        <div class="right-sidebar-body-content">
            <h4 class="weight-600 font-18 pb-10">Header Background</h4>
            <div class="sidebar-btn-group pb-30 mb-10">
                <a href="javascript:void(0);" class="btn btn-outline-primary header-primary">White</a>
            </div>

            <h4 class="weight-600 font-18 pb-10">Sidebar Background</h4>
            <div class="sidebar-btn-group pb-30 mb-10">
                <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-light">White</a>
            </div>
        </div>
    </div>
</div>
