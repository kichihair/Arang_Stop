<?php include 'header.php'; ?>
<style>
.about-wrap {max-width:1050px;margin:32px auto;padding:0 16px;color:#333;}
.about-panel {padding:24px;margin-bottom:22px;}
.about-grid {display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px;}
.about-feature {padding:16px;background:#fafafa;}
.about-feature h4 {margin:0 0 8px;}
.about-feature p {margin:0;line-height:1.6;}
.about-step {display:flex;align-items:center;gap:12px;padding:10px 0;}
.about-step .w3-badge {flex-shrink:0;}
@media(max-width:600px) {.about-grid {grid-template-columns:1fr;} .about-panel {padding:18px;}}
</style>
<main class="about-wrap">
<section class="w3-indigo w3-round-large about-panel">
<h1><b>About Arang Stop</b></h1><p class="w3-large">Your Burger, Your Way – Pick-Up or Dine-In!</p>
</section>
<section class="w3-white w3-card-2 w3-round-large about-panel">
<p class="w3-large" style="line-height:1.7">Arang Stop is a web-based food ordering system that allows customers to browse the burger menu, place orders and choose between dining in and taking away. Staff can manage menu items, customer records and orders through the staff dashboard.</p>
</section>
<section class="w3-white w3-card-2 w3-round-large about-panel">
<h2 class="w3-text-indigo"><b>Key Features</b></h2>
<div class="about-grid"><div class="about-feature w3-border w3-round-large"><h4 class="w3-text-indigo"><b>Digital Menu</b></h4><p>Browse available food items and prices.</p></div>
<div class="about-feature w3-border w3-round-large"><h4 class="w3-text-indigo"><b>Shopping Cart</b></h4><p>Add items and review quantities before checkout.</p></div>
<div class="about-feature w3-border w3-round-large"><h4 class="w3-text-indigo"><b>Order Options</b></h4><p>Choose take-out or dine-in with a table number.</p></div>
<div class="about-feature w3-border w3-round-large"><h4 class="w3-text-indigo"><b>Checkout</b></h4><p>Use the card payment form or choose payment at the counter.</p></div>
<div class="about-feature w3-border w3-round-large"><h4 class="w3-text-indigo"><b>Order Tracking</b></h4><p>View order status and access printable receipts.</p></div>
<div class="about-feature w3-border w3-round-large"><h4 class="w3-text-indigo"><b>Staff Management</b></h4><p>Manage menu items, current orders, order history and sales analysis.</p></div>
</div>
</section>
<section class="w3-white w3-card-2 w3-round-large about-panel">
<h2 class="w3-text-indigo"><b>How It Works</b></h2><div class="about-step"><span class="w3-badge w3-indigo">1</span><span>Browse the menu and sign in.</span></div>
<div class="about-step"><span class="w3-badge w3-indigo">2</span><span>Add food to your cart and choose an order type.</span></div>
<div class="about-step"><span class="w3-badge w3-indigo">3</span><span>Complete checkout and view your receipt.</span></div>
<div class="about-step"><span class="w3-badge w3-indigo">4</span><span>Check your order status.</span></div>

</section>
<section class="w3-white w3-card-2 w3-round-large about-panel">
<h2 class="w3-text-indigo"><b>Technology Stack</b></h2>
<div class="about-grid"><div><h4>Frontend</h4><p>HTML, CSS, JavaScript, W3.CSS</p></div><div><h4>Backend &amp; Database</h4><p>PHP, MySQL, FPDF</p></div></div>
</section>
</main>
</body></html>
