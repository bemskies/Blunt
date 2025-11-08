<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CARS - Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div class="navbar">
        <nav>
            <a href="index.html">Report</a> 
            <a href="delete_report.php">Delete</a> 
            <a href="get_report_details.php">View Report</a> 
            <a href="get_reports.php">Reports</a> 
            <a href="update_status.php">Update</a> 
            <a href="view_media.php">Media</a> 
        </nav>
    </div>
    <div class="dashboard-container">
        <header>
            <h1><i class="fas fa-shield-alt"></i> Child Abuse Reporting System</h1>
            <div class="user-controls">
                <span id="username">Admin</span>
                <button id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </div>
        </header>
        
        <div class="dashboard-content">
            <div class="stats-summary">
                <div class="stat-card pending">
                    <h3>Pending</h3>
                    <span id="pendingCount">0</span>
                </div>
                <div class="stat-card under-review">
                    <h3>Under Review</h3>
                    <span id="reviewCount">0</span>
                </div>
                <div class="stat-card resolved">
                    <h3>Resolved</h3>
                    <span id="resolvedCount">0</span>
                </div>
            </div>
            
            <div class="reports-table-container">
                <h2><i class="fas fa-list"></i> Recent Reports</h2>
                <div class="table-controls">
                    <input type="text" id="searchInput" placeholder="Search reports...">
                    <select id="statusFilter">
                        <option value="all">All Statuses</option>
                        <option value="Pending">Pending</option>
                        <option value="Under Review">Under Review</option>
                        <option value="Resolved">Resolved</option>
                    </select>
                </div>
                <table id="reportsTable" border="1">
                    <thead>
                        <tr>
                            <th>Case ID</th>
                            <th>Child Name</th>
                            <th>Age</th>
                            <th>Incident Date</th>
                            <th>Status</th>
                            <th>Media</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    
    <!-- View Report Modal -->
    <div id="reportModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2 id="modalTitle">Case Details</h2>
            <div id="modalBody"></div>
        </div>
    </div>
    
    <script src="dashboard.js"></script>
</body>
</html>

