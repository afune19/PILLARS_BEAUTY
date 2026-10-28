<?php
session_start();
require_once "admin/config/db.php";

/* ================= HERO IMAGES ================= */
$heroImages = $pdo->query("
    SELECT title, image_path
    FROM hero_images
    WHERE is_active = 1 AND status = 1
    ORDER BY created_at DESC
")->fetchAll(PDO::FETCH_ASSOC);

/* ================= SERVICES ================= */
$services = $pdo->query("
    SELECT id, name, description, image
    FROM services
    ORDER BY created_at DESC
")->fetchAll(PDO::FETCH_ASSOC);

/* ================= APPOINTMENT ================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book'])) {

    $stmt = $pdo->prepare("
        INSERT INTO appointments
        (customer_name, customer_phone, customer_email, service_id, appointment_date, appointment_time, message)
        VALUES (?,?,?,?,?,?,?)
    ");

    try {
        $stmt->execute([
            $_POST['name'],
            $_POST['phone'],
            $_POST['email'],
            $_POST['service_id'],
            $_POST['date'],
            $_POST['time'],
            $_POST['message']
        ]);

        header("Location: index.php?success=1#appointment");
        exit;

    } catch (PDOException $e) {

        if ($e->getCode() == 23000) {
            header("Location: index.php?duplicate=1#appointment");
            exit;
        }

        throw $e;
    }
}

/* ================= CONTACT ================= */
$contaError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_send'])) {

    if (!$_POST['full_name'] || !$_POST['email'] || !$_POST['message']) {
        $contaError = "Please fill in all required fields.";
    } else {

        $stmt = $pdo->prepare("
            INSERT INTO contact_messages (full_name, email, phone, message)
            VALUES (?,?,?,?)
        ");

        $stmt->execute([
            $_POST['full_name'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['message']
        ]);

        header("Location: index.php?sent=1#contact");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Pillars Beauty Art</title>
<meta name="description" content="Pillars Beauty Art offers luxury beauty treatments, skincare, and personalized wellness services. Book your appointment today.">
<meta name="keywords" content="Beauty salon, skincare, makeup, spa, beauty services, Pillars Beauty Art">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Open Graph -->
<meta property="og:title" content="Pillars Beauty Art">
<meta property="og:description" content="Luxury beauty services tailored just for you.">
<meta property="og:type" content="website">
<meta property="og:image" content="admin/pages/uploads/hero/<?= $heroImages[0]['image_path'] ?? '' ?>">



<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
:root{
    --primary:#e91e63;
    --shadow:0 15px 40px rgba(0,0,0,.08);
}

*{box-sizing:border-box}

body{
    margin:0;
    font-family:Poppins,sans-serif;
    background:#fff0f5;
    overflow-x:hidden;
}

body.menu-open{ overflow:hidden; }

a{text-decoration:none}

/* ================= HEADER ================= */
header{
    position:sticky;
    top:0;
    z-index:9999;
    background:var(--primary);
    box-shadow:0 4px 15px rgba(0,0,0,.15);
}

.header-container{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 8%;
    height:70px;
}

.logo{
    color:#fff;
    font-size:24px;
    font-weight:700;
}

nav.desktop-menu ul{
    list-style:none;
    display:flex;
    gap:30px;
    margin:0;
    padding:0;
}

nav.desktop-menu li a{
    color:#fff;
    font-weight:600;
    padding:10px 0;
    display:block;
    transition:.3s;
}

nav.desktop-menu li a:hover{ color:#ffd6e7; }

.menu-toggle{
    display:none;
    font-size:26px;
    background:none;
    border:none;
    color:#fff;
    cursor:pointer;
}

@media(max-width:768px){
    nav.desktop-menu{display:none;}
    .menu-toggle{display:block;}
}

/* ================= MOBILE MENU ================= */
.mobile-menu{
    position:fixed;
    top:0;
    right:-320px;
    width:320px;
    height:100vh;
    background:var(--primary);
    transition:.35s ease;
    z-index:99999;
    padding:80px 20px 20px;
    box-shadow:-5px 0 30px rgba(0,0,0,.15);
}

.mobile-menu.open{ right:0; }

.mobile-menu ul{ list-style:none; padding:0; margin:0; }

.mobile-menu a{
    display:block;
    padding:16px;
    color:#fff;
    font-weight:600;
    border-bottom:1px solid rgba(255,255,255,.2);
}

.mobile-menu a:hover{ background:#ff5f98; }

.close-menu{
    position:absolute;
    top:20px;
    right:25px;
    font-size:28px;
    color:#fff;
    cursor:pointer;
}

.menu-overlay{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.4);
    display:none;
    z-index:99990;
}

.menu-overlay.show{ display:block; }

/* ================= HERO ================= */
.hero{
    position:relative;
    min-height:90vh;
    overflow:hidden;
}

.hero-slide{
    position:absolute;
    inset:0;
    opacity:0;
    transition:opacity 1.2s ease;
}

.hero-slide.active{ opacity:1; }

.hero-slide img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.hero-overlay{
    position:absolute;
    inset:0;
    background:linear-gradient(90deg,#fff0f5ee,#fff0f544);
}

.hero-content{
    position:relative;
    z-index:2;
    min-height:90vh;
    display:flex;
    align-items:center;
    padding:8%;
}

.hero-card{
    background:#ffffffcc;
    padding:45px;
    border-radius:36px;
    max-width:520px;
    box-shadow:var(--shadow);
}

/* ================= SERVICES ================= */
section{ padding:80px 8% }
h2{ text-align:center; margin-bottom:60px }

.service-card{
    display:flex;
    background:#fff;
    border-radius:32px;
    overflow:hidden;
    box-shadow:var(--shadow);
    margin-bottom:70px;
}

.service-card.reverse{ flex-direction:row-reverse; }

.service-text{ flex:1; padding:45px; }
.service-image{ flex:1; }
.service-image img{ width:100%; height:100%; object-fit:cover; }

.read-more-btn{
    margin-top:20px;
    background:var(--primary);
    color:#fff;
    border:none;
    padding:12px 24px;
    border-radius:999px;
    font-weight:600;
    cursor:pointer;
}

.read-more-btn:hover{ opacity:.9; }

@media(max-width:768px){
    .service-card,
    .service-card.reverse{ flex-direction:column; }
}

/* ================= MODAL ================= */
.modal{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.6);
    z-index:999999;
    justify-content:center;
    align-items:center;
}

.modal-content{
    background:#fff;
    padding:40px;
    border-radius:30px;
    max-width:600px;
    width:90%;
    position:relative;
    box-shadow:var(--shadow);
    animation:fadeIn .3s ease;
}

@keyframes fadeIn{
    from{transform:scale(.9); opacity:0;}
    to{transform:scale(1); opacity:1;}
}

.close-modal{
    position:absolute;
    top:15px;
    right:20px;
    font-size:26px;
    cursor:pointer;
}

.modal-close-btn{
    margin-top:20px;
    background:var(--primary);
    color:#fff;
    border:none;
    padding:12px 25px;
    border-radius:999px;
    cursor:pointer;
}

/* ================= FORMS ================= */
.form-card{
    background:#fff;
    padding:50px;
    border-radius:36px;
    max-width:900px;
    margin:auto;
    box-shadow:var(--shadow);
}

.form-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}

.form-full{ grid-column:1/-1; }

input,select,textarea{
    padding:14px;
    border-radius:20px;
    border:1px solid #ddd;
}

button{
    background:var(--primary);
    color:#fff;
    border:none;
    padding:15px;
    border-radius:999px;
    font-weight:600;
    cursor:pointer;
}

button:hover{ opacity:.9; }
</style>
</head>
<body>

<!-- HEADER -->
<header>
<div class="header-container">
    <div class="logo">Pillars Beauty Art</div>

    <nav class="desktop-menu">
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#appointment">Book Appointment</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </nav>

    <button class="menu-toggle">☰</button>
</div>
</header>

<div class="menu-overlay"></div>

<div class="mobile-menu">
    <div class="close-menu">✕</div>
    <ul>
        <li><a href="#home">Home</a></li>
        <li><a href="#services">Services</a></li>
        <li><a href="#appointment">Book Appointment</a></li>
        <li><a href="#contact">Contact</a></li>
    </ul>
</div>

<!-- HERO -->
<section id="home" class="hero">
<?php foreach($heroImages as $i=>$h): ?>
<div class="hero-slide <?= $i===0?'active':'' ?>">
    <img src="admin/pages/uploads/hero/<?= htmlspecialchars($h['image_path']) ?>">
    <div class="hero-overlay"></div>
</div>
<?php endforeach; ?>

<div class="hero-content">
    <div class="hero-card">
        <h1><?= htmlspecialchars($heroImages[0]['title'] ?? 'Pillars Beauty Art') ?></h1>
        <p>Luxury beauty services tailored just for you.</p>
    </div>
</div>
</section>

<!-- SERVICES -->
<section id="services">
<h2>Our Signature Services</h2>

<?php foreach($services as $i=>$s): ?>
<div class="service-card <?= $i%2?'reverse':'' ?>">
    <div class="service-text">
        <h3><?= htmlspecialchars($s['name']) ?></h3>
        <p><?= htmlspecialchars(mb_strimwidth(strip_tags($s['description']),0,220,'...')) ?></p>

        <button
            class="read-more-btn"
            data-title="<?= htmlspecialchars($s['name']) ?>"
            data-description="<?= htmlspecialchars($s['description']) ?>"
        >
            Read More
        </button>
    </div>

    <div class="service-image">
        <img src="admin/pages/uploads/services/<?= htmlspecialchars($s['image']) ?>">
    </div>
</div>
<?php endforeach; ?>
</section>

<!-- SERVICE MODAL -->
<div id="serviceModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h3 id="modalTitle"></h3>
        <p id="modalDescription"></p>
        <button class="modal-close-btn">Close</button>
    </div>
</div>

<!-- APPOINTMENT -->
<section id="appointment">
<h2>Book Appointment</h2>
<form method="POST" class="form-card">
<div class="form-grid">
    <input name="name" placeholder="Full Name" required>
    <input name="phone" placeholder="Phone" required>
    <input name="email" placeholder="Email">
    <select name="service_id" required>
        <option value="">Select Service</option>
        <?php foreach($services as $s): ?>
        <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
        <?php endforeach; ?>
    </select>
    <input type="date" name="date" required>
    <input type="time" name="time" required>
    <textarea name="message" class="form-full" placeholder="Notes"></textarea>
    <button name="book" class="form-full">Book Appointment</button>
</div>
</form>
</section>

<!-- CONTACT -->
<section id="contact">
<div class="form-card">
<h2>Contact Us</h2>

<?php if(isset($_GET['sent'])): ?>
<p style="color:green">Message sent successfully</p>
<?php elseif($contaError): ?>
<p style="color:red"><?= htmlspecialchars($contaError) ?></p>
<?php endif; ?>

<form method="POST" class="form-grid">
    <input name="full_name" placeholder="Full Name" required>
    <input name="email" placeholder="Email" required>
    <input name="phone" class="form-full" placeholder="Phone">
    <textarea name="message" class="form-full" placeholder="Message" required></textarea>
    <button name="contact_send" class="form-full">Send Message</button>
</form>
</div>
</section>

<script>
/* Hero Slider */
const slides = document.querySelectorAll('.hero-slide');
let i = 0;
if (slides.length > 1) {
    setInterval(() => {
        slides[i].classList.remove('active');
        i = (i + 1) % slides.length;
        slides[i].classList.add('active');
    }, 4000);
}

/* Mobile Menu */
const mobileMenu = document.querySelector(".mobile-menu");
const overlay = document.querySelector(".menu-overlay");
const toggleBtn = document.querySelector(".menu-toggle");
const closeBtn = document.querySelector(".close-menu");

function openMenu(){
    mobileMenu.classList.add("open");
    overlay.classList.add("show");
    document.body.classList.add("menu-open");
}

function closeMenu(){
    mobileMenu.classList.remove("open");
    overlay.classList.remove("show");
    document.body.classList.remove("menu-open");
}

toggleBtn.addEventListener("click", openMenu);
closeBtn.addEventListener("click", closeMenu);
overlay.addEventListener("click", closeMenu);

/* Service Modal */
const modal = document.getElementById("serviceModal");
const modalTitle = document.getElementById("modalTitle");
const modalDescription = document.getElementById("modalDescription");
const closeModal = document.querySelector(".close-modal");
const modalCloseBtn = document.querySelector(".modal-close-btn");

document.querySelectorAll(".read-more-btn").forEach(button => {
    button.addEventListener("click", () => {
        modalTitle.textContent = button.dataset.title;
        modalDescription.textContent = button.dataset.description;
        modal.style.display = "flex";
        document.body.style.overflow = "hidden";
    });
});

function closeServiceModal(){
    modal.style.display = "none";
    document.body.style.overflow = "auto";
}

closeModal.addEventListener("click", closeServiceModal);
modalCloseBtn.addEventListener("click", closeServiceModal);

modal.addEventListener("click", (e) => {
    if(e.target === modal){
        closeServiceModal();
    }
});
</script>

<?php include 'footer.php'; ?>
</body>
</html>
