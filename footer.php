 <footer class="site-footer">
  <style>
    :root {
      --beauty-main: #e91e63;
      --beauty-dark: #ad1457;
    }

    .site-footer {
      margin-top: 40px;
      padding: 55px 24px;
      background: linear-gradient(
        135deg,
        rgba(233,30,99,.35),
        rgba(173,20,87,.85)
      );
      backdrop-filter: blur(6px);
      color:  color: #000; 
      width: 100%;
      font-family: 'Poppins', Arial, sans-serif;
      position: relative;
      overflow: hidden;
    }

    /* Soft Glow Overlay */
    .site-footer::before {
      content: "";
      position: absolute;
      top: -50%;
      left: -20%;
      width: 600px;
      height: 600px;
      background: radial-gradient(circle, rgba(255,255,255,.15), transparent 70%);
      transform: rotate(25deg);
    }

    .footer-wrap {
      max-width: 1250px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1fr 1fr 1.5fr;
      gap: 40px;
      position: relative;
      z-index: 2;
    }

    .footer-column h3,
    .footer-column h4 {
      margin-top: 0;
      font-weight: 600;
      margin-bottom: 18px;
      font-size: 20px;
      letter-spacing: .5px;
      color:  color: #000; 
    }

    .footer-column p,
    .footer-column li,
    .footer-column a {
      font-size: 15px;
      line-height: 1.8;
      color: rgba(255,255,255,.95);
    }

    .footer-column ul {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .footer-column li {
      margin-bottom: 12px;
    }

    .footer-column a {
      text-decoration: none;
      transition: .3s ease;
    }

    .footer-column a:hover {
      text-decoration: underline;
      opacity: .9;
    }

    .map-container {
      width: 100%;
      margin-top: 18px;
    }

    .map-container iframe {
      border: 0;
      width: 100%;
      height: 230px;
      border-radius: 14px;
      box-shadow: 0 10px 25px rgba(0,0,0,.3);
    }

    .copy {
      margin-top: 18px;
      font-size: 14px;
      opacity: .9;
      text-align: center;
    }

    /* WhatsApp Floating */
    .whatsapp-float {
      position: fixed;
      bottom: 25px;
      right: 25px;
      text-decoration: none;
      z-index: 9999;
    }

    .wa-box {
      display: flex;
      align-items: center;
      justify-content: center;
      background: #25D366;
      width: 62px;
      height: 62px;
      border-radius: 50%;
      box-shadow: 0 8px 25px rgba(0,0,0,.4);
      animation: floatAnim 2s ease-in-out infinite;
      transition: .3s;
    }

    .wa-box img {
      width: 32px;
      height: 32px;
    }

    .wa-box:hover {
      background: #1EBE59;
      transform: scale(1.1);
    }

    @keyframes floatAnim {
      0% { transform: translateY(0); }
      50% { transform: translateY(-6px); }
      100% { transform: translateY(0); }
    }

    @media (max-width: 900px) {
      .footer-wrap {
        grid-template-columns: 1fr;
      }

      .map-container iframe {
        height: 200px;
      }
    }
  </style>

  <div class="footer-wrap">

    <!-- Contact Info -->
    <div class="footer-column">
      <h4>Contact Us</h4>
      <p><strong>Location:</strong><br>The Bazaar, Nairobi CBD</p>
      <p><strong>Working Hours:</strong><br>7:00 AM – 8:00 PM</p>
      <p><strong>Phone:</strong><br>+254798196071</p>
      <p><strong>Email:</strong><br>
        <a href="mailto:pillarbeautyart@gmail.com">pillarbeautyart@gmail.com</a>
      </p>
    </div>

    <!-- Quick Links -->
    <div class="footer-column">
      <h4>Quick Links</h4>
      <ul>
        <li>💄 <a href="#home">Home</a></li>
        <li>💅 <a href="#services">Services</a></li>
        <li>📅 <a href="#appointment">Book Appointment</a></li>
        <li>📞 <a href="#contact">Contact</a></li>
      </ul>
    </div>

    <!-- Branding / Map -->
    <div class="footer-column">
      <h3>Pillars Beauty Art</h3>
      <p>Luxury beauty treatments crafted to enhance your natural glow in a calm, elegant space.</p>

      <div class="map-container">
        <iframe
          src="https://www.google.com/maps?q=-1.2818592018348896,36.82133119222346&hl=en&z=17&output=embed"
          allowfullscreen=""
          loading="lazy">
        </iframe>
      </div>

      <p class="copy">© <?php echo date('Y'); ?> Pillars Beauty Art • All Rights Reserved.</p>
    </div>

  </div>

  <!-- WhatsApp -->
  <a href="https://wa.me/254798196071?text=Hello%20Pillars%20Beauty%20Art%2C%20I%20would%20like%20to%20book%20a%20service." 
     class="whatsapp-float" target="_blank">
      <div class="wa-box">
          <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
      </div>
  </a>

</footer>
