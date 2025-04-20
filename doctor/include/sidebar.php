<aside class="sidebar">
    <div class="sidebar-top">
        <span><i class="fas fa-plus"></i> Hospital management System</span>
    </div>
    <div class="sidebar-header">
        <span>
            <div class="profile-pic"><img src="../assets/images/1656551981avatar.png" alt=""></div>
        </span>
        <span>Doctor (<?=isset($_SESSION['docid']) ? $_SESSION['docid'] : "" ?>)</span>
    </div>
    <div class="sidebar-menu">
        <div class="list-group">
            <a href="./" class="list-group-item list-group-action"><span class="fas fa-tachometer-alt"></span><span>Dashboard</span></a>
            <a href="./?page=appointments" class="list-group-item list-group-action"><span class="fas fa-list-ul"></span><span>Appointments</span></a>
            <a href="./?page=patient_visits" class="list-group-item list-group-action"><span class="fas fa-pen"></span><span>Patient Visits</span></a>
        </div>
    </div>
    <div class="log">
        <a href="logout.php"><span class="fas fa-sign-out-alt"></span><span>Logout</span></a>
    </div>
</aside>