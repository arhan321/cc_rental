document.addEventListener("DOMContentLoaded", function () {
  // === KATEGORI PRODUK SLIDER ===
  const productList = document.getElementById("productList");
  const prevBtn = document.getElementById("prevBtn");
  const nextBtn = document.getElementById("nextBtn");
  let scrollTimeout;

  if (productList && prevBtn && nextBtn) {
    prevBtn.addEventListener("click", () => {
      productList.scrollBy({ left: -300, behavior: 'smooth' });
      showScrollbarTemporarily();
    });

    nextBtn.addEventListener("click", () => {
      productList.scrollBy({ left: 300, behavior: 'smooth' });
      showScrollbarTemporarily();
    });

    productList.addEventListener("scroll", showScrollbarTemporarily);

    function showScrollbarTemporarily() {
      productList.classList.add("show-scrollbar");
      clearTimeout(scrollTimeout);
      scrollTimeout = setTimeout(() => {
        productList.classList.remove("show-scrollbar");
      }, 2000);
    }
  }

  // === CART SIDEBAR ===
  const cartSidebar = document.getElementById('cartSidebar');
  if (cartSidebar) {
    cartSidebar.addEventListener('shown.bs.offcanvas', function () {
      document.body.style.overflow = 'auto';
    });
  }
});


document.getElementById("loginForm").addEventListener("submit", function(e) {
  e.preventDefault();

  const email = document.getElementById("emailLogin").value;
  const password = document.getElementById("passwordLogin").value;

  fetch("/login", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json",
      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
    },
    credentials: "same-origin",
    body: JSON.stringify({ email, password })
  })
  .then(response => response.json())
  .then(data => {
    if (data.status === "success") {
      window.location.href = "/"; // Redirect ke home.blade.php
    } else {
      alert("Login gagal: " + data.message);
    }
  })
  .catch(error => {
    console.error("Login Error:", error);
    alert("Terjadi kesalahan saat login.");
  });
});

document.getElementById('registerForm').addEventListener('submit', async function(e) {
  e.preventDefault();

  const formData = new FormData(this);

  try {
    const response = await fetch('/register', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json'
      },
      body: formData
    });

    if (!response.ok) throw await response.json();

    const result = await response.json();
    window.location.href = result.redirect;
  } catch (error) {
    alert("Terjadi kesalahan saat mendaftar:\nGagal: " + JSON.stringify(error));
  }
});