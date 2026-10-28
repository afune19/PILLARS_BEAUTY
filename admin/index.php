<?php
require __DIR__ . '/auth.php';
require __DIR__ . '/config/db.php';

$role = $_SESSION['admin_role'] ?? 'admin';

/* Page routing */
$page = $_GET['page'] ?? 'dashboard';
$allowedPages = [
    'dashboard',
    'services',
    'appointments',
    'appointments_list',
    'staff',
    'reports',
    'contacts',
    'hero'
];

if (!in_array($page, $allowedPages)) {
    $page = 'dashboard';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Beauty Admin Panel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
/* ===== VARIABLES ===== */
:root {
    --admin-primary: #c96c86;
    --admin-secondary: #f7d1db;
    --admin-bg: #fff0f5;
    --admin-card: #ffffff;
    --admin-shadow: 0 8px 20px rgba(0,0,0,.08);
}

*{
    box-sizing:border-box;
    margin:0;
    padding:0;
}

html, body{
    width:100%;
    overflow-x:hidden;
}

body{
    font-family:Poppins,Segoe UI,sans-serif;
    background:var(--admin-bg);
}

/* ===== WRAPPER ===== */
.admin-wrapper{
    display:flex;
    min-height:100vh;
    width:100%;
}

/* ===== SIDEBAR ===== */
.admin-sidebar{
    width:260px;
    min-width:260px;
    background:linear-gradient(180deg,var(--admin-primary),#e08ca4);
    color:#fff;
    padding:30px 20px;
    display:flex;
    flex-direction:column;
    transition:0.3s ease;
}

.admin-sidebar h2{
    text-align:center;
    margin-bottom:30px;
    font-size:22px;
}

.admin-sidebar a{
    padding:12px 16px;
    margin-bottom:8px;
    border-radius:10px;
    color:#fff;
    text-decoration:none;
    font-weight:500;
    display:flex;
    align-items:center;
    gap:10px;
    transition:0.3s;
    font-size:14px;
}

.admin-sidebar a.admin-active,
.admin-sidebar a:hover{
    background:rgba(255,255,255,.2);
}

.admin-menu-title{
    font-size:11px;
    margin:15px 0 6px 12px;
    opacity:.7;
    text-transform:uppercase;
}

/* ===== MAIN ===== */
.admin-main{
    flex:1;
    padding:30px;
    display:flex;
    flex-direction:column;
    width:100%;
}

.admin-topbar{
    background:#fff;
    padding:18px 22px;
    border-radius:16px;
    box-shadow:var(--admin-shadow);
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
    font-weight:500;
    flex-wrap:wrap;
    gap:10px;
}

.admin-topbar a{
    color:var(--admin-primary);
    text-decoration:none;
    font-weight:600;
    transition:0.3s;
}

.admin-topbar a:hover{
    opacity:.8;
}

.admin-page-content{
    background:var(--admin-card);
    padding:25px;
    border-radius:16px;
    box-shadow:var(--admin-shadow);
    min-height:60vh;
    width:100%;
    overflow-x:auto;
}

/* ===== FOOTER ===== */
.admin-footer{
    margin-top:auto;
    text-align:center;
    font-size:14px;
    color:#777;
    margin-top:25px;
    padding:10px;
}

/* ============================= */
/* ===== LARGE SCREENS ===== */
/* ============================= */
@media (min-width:1400px){
    .admin-main{
        padding:40px 60px;
    }
    .admin-page-content{
        padding:35px;
    }
}

/* ============================= */
/* ===== TABLETS ===== */
/* ============================= */
@media (max-width:1024px){
    .admin-sidebar{
        width:220px;
        min-width:220px;
    }
    .admin-main{
        padding:20px;
    }
}

/* ============================= */
/* ===== MOBILE ===== */
/* ============================= */
@media (max-width:768px){

    .admin-wrapper{
        flex-direction:column;
    }

    .admin-sidebar{
        width:100%;
        min-width:100%;
        flex-direction:row;
        overflow-x:auto;
        padding:15px;
        gap:10px;
    }

    .admin-sidebar h2,
    .admin-menu-title{
        display:none;
    }

    .admin-sidebar a{
        margin:0;
        white-space:nowrap;
        font-size:13px;
        padding:10px 14px;
    }

    .admin-main{
        padding:15px;
    }

    .admin-topbar{
        flex-direction:column;
        align-items:flex-start;
    }

    .admin-page-content{
        padding:18px;
    }
}

/* ============================= */
/* ===== VERY SMALL SCREENS ===== */
/* ============================= */
@media (max-width:480px){

    .admin-sidebar a{
        font-size:12px;
        padding:8px 10px;
    }

    .admin-topbar{
        padding:14px;
        font-size:14px;
    }

    .admin-page-content{
        padding:15px;
    }

    .admin-footer{
        font-size:12px;
    }
}
</style>
</head>

<body>

<div class="admin-wrapper">

<!-- SIDEBAR -->
<div class="admin-sidebar">
    <h2>Pillars Beauty</h2>

    <p class="admin-menu-title">Overview</p>
    <a href="index.php?page=dashboard" class="<?= $page==='dashboard'?'admin-active':'' ?>">📊 Dashboard</a>
    <a href="index.php?page=services" class="<?= $page==='services'?'admin-active':'' ?>">💅 Services</a>

    <p class="admin-menu-title">Appointments</p>
    <a href="index.php?page=appointments" class="<?= $page==='appointments'?'admin-active':'' ?>">📅 Book Appointment</a>
    <a href="index.php?page=appointments_list" class="<?= $page==='appointments_list'?'admin-active':'' ?>">📋 Booked Appointments</a>

    <?php if ($role === 'admin'): ?>
    <p class="admin-menu-title">Management</p>
    <a href="index.php?page=hero" class="<?= $page==='hero'?'admin-active':'' ?>">👩‍💼 Hero Slides</a>
    <a href="index.php?page=staff" class="<?= $page==='staff'?'admin-active':'' ?>">👩‍💼 Staff</a>
    <a href="index.php?page=reports" class="<?= $page==='reports'?'admin-active':'' ?>">📈 Reports</a>
    <a href="index.php?page=contacts" class="<?= $page==='contacts'?'admin-active':'' ?>">✉️ Messages</a>
    <?php endif; ?>

    <p class="admin-menu-title">Account</p>
    <a href="logout.php">🚪 Logout</a>
</div>

<!-- MAIN -->
<div class="admin-main">

    <div class="admin-topbar">
        <strong><?= htmlspecialchars($_SESSION['admin_name']) ?> (<?= ucfirst($role) ?>)</strong>
        <div>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="admin-page-content">
        <?php
        $pagePath = __DIR__ . "/pages/{$page}.php";
        if (file_exists($pagePath)) {
            include $pagePath;
        } else {
            echo "<h3>Page not found</h3>";
        }
        ?>
    </div>

    <div class="admin-footer">
        © <?= date('Y') ?> Pillars Beauty Parlor • Admin Panel
    </div>

</div>
</div>

</body>
</html>
