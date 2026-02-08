
(function ($) {
  "use strict";

  // ЁЯЯв Sticky Header
  $(window).scroll(function () {
    var scroll = $(window).scrollTop();
    var box = $("#top").height();
    var header = $("header").height();
    if (scroll >= box - header) {
      $("header").addClass("background-header");
    } else {
      $("header").removeClass("background-header");
    }
  });

  // Header sticky
  $(window).scroll(function () {
    var scroll = $(window).scrollTop();
    var navbar = $(".navbar");

    if (scroll > 50) {
      navbar.addClass("sticky");
    } else {
      navbar.removeClass("sticky");
    }
  });

  // Mobile Nav
  function mobileNav() {
    var width = $(window).width();
    $(".submenu").off("click").on("click", function () {
      if (width < 767) {
        $(".submenu ul").removeClass("active");
        $(this).find("ul").toggleClass("active");
      }
    });
  }
  mobileNav();
  $(window).on("resize", mobileNav);

  // Smooth Scroll
  $(".scroll-to-section a[href*=\\#]:not([href=\\#])").on("click", function () {
    var target = $(this.hash);
    if (target.length) {
      $("html,body").animate({ scrollTop: target.offset().top - 80 }, 700);
      return false;
    }
  });

})(jQuery);

// ===============================
// Vanilla JS
// ===============================

// Bottom Nav Hide on Scroll
let lastScrollY = window.scrollY;
const bottomNav = document.getElementById("bottomNav");
window.addEventListener("scroll", () => {
  if (!bottomNav) return;
  const currentScrollY = window.scrollY;
  if (window.innerWidth > 768) {
    if (currentScrollY > lastScrollY && currentScrollY > 400) {
      bottomNav.classList.add("hide");
    } else if (currentScrollY < lastScrollY) {
      bottomNav.classList.remove("hide");
    }
    lastScrollY = currentScrollY;
  }
});

// Mobile Menu
const menuBtn = document.getElementById("openMenu");
const menu = document.getElementById("slideMenu");
const overlay = document.getElementById("overlay");
menuBtn?.addEventListener("click", () => {
  menu?.classList.add("active");
  overlay?.classList.add("active");
});
overlay?.addEventListener("click", () => {
  menu?.classList.remove("active");
  overlay?.classList.remove("active");
});

// Scroll-to-top Button
const mybutton = document.getElementById("myBtn");
window.addEventListener("scroll", () => {
  if (!mybutton) return;
  mybutton.style.display = document.documentElement.scrollTop > 20 ? "block" : "none";
});
function topFunction() {
  document.documentElement.scrollTop = 0;
}

// Search Box
// Search Box
/*const searchBox = document.getElementById("searchBox");
const searchIcon = document.getElementById("searchIcon");
const searchInput = document.getElementById("searchInput");
searchIcon?.addEventListener("click", () => {
  searchBox?.classList.toggle("active");
  searchInput?.focus();
});
document.addEventListener("click", (e) => {
  if (searchBox && !searchBox.contains(e.target) && e.target !== searchIcon) {
    searchBox.classList.remove("active");
  }
});*/


document.addEventListener("DOMContentLoaded", () => {
    const searchIcon = document.getElementById("searchIcon");
    const searchInput = document.getElementById("searchInput");
    const searchResults = document.getElementById("searchResults");

    // 🔹 Toggle search input
    searchIcon.addEventListener("click", () => {
        if (searchInput.style.display === "none") {
            searchInput.style.display = "block";
            searchInput.focus();
        } else {
            searchInput.style.display = "none";
            searchResults.style.display = "none";
            searchInput.value = "";
        }
    });

    // 🔹 Debounce input
    let timeout;
    searchInput.addEventListener("input", () => {
        clearTimeout(timeout);
        const query = searchInput.value.trim();
        if (!query) {
            searchResults.style.display = "none";
            searchResults.innerHTML = "";
            return;
        }
        timeout = setTimeout(() => fetchSearchResults(query), 300);
    });

    // 🔹 Fetch JSON results
    function fetchSearchResults(query) {
    const basePath = "window.location.origin + window.location.pathname.replace(/\/[^/]*$/, '')";
    // const basePath = "https://dev.khut.shop/khut-bd-site/public";
    fetch(`${basePath}/search?q=${encodeURIComponent(query)}`)
        .then(res => res.json())
        .then(data => renderResults(data))
        .catch(err => console.error(err));
}

    // 🔹 Render dropdown
    function renderResults(data) {
        if (!data.length) {
            searchResults.style.display = "none";
            searchResults.innerHTML = "";
            return;
        }

        searchResults.innerHTML = data.map(item => {
            return `<div class="search-item" data-type="${item.type}" data-id="${item.id}" 
                        style="padding:5px 10px; cursor:pointer; border-bottom:1px solid #eee;">
                        ${item.name} <small style="color:#666;">(${item.type})</small>
                    </div>`;
        }).join("");

        searchResults.style.display = "block";

        // Click to redirect
        document.querySelectorAll("#searchResults .search-item").forEach(el => {
            el.addEventListener("click", () => {
                const type = el.dataset.type;
                const id = el.dataset.id;
               if (type === "product") {
                    // window.location.href = `/product/${id}`; // ❌ পুরানো
                    window.location.href = `/product-details/${id}`; // ✅ ঠিক করা
                } else if (type === "category") {
                    window.location.href = `/category/${id}`;
                }
            });
        });
    }

    // 🔹 Click outside to hide
    document.addEventListener("click", e => {
        if (!searchInput.contains(e.target) && !searchIcon.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.style.display = "none";
        }
    });
});




















// ===============================
// Cart Sidebar
// ===============================
let cart = JSON.parse(localStorage.getItem('cart')) || [];

// Update cart counts
function updateCartCounts() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartCounts = document.querySelectorAll(".cart-count");
    let totalQty = cart.reduce((sum, item) => sum + item.qty, 0);
    cartCounts.forEach(el => el.textContent = totalQty);
    localStorage.setItem("cartCount", totalQty);
}


// Render Cart
function renderCart() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartList = document.getElementById('cartList');
    const cartItems = document.getElementById('cartItems');
    const cartTotal = document.getElementById('cartTotal');
    const returnShop = document.getElementById('returnShop');

    if (!cartList || !cartItems || !cartTotal) return;

    cartList.innerHTML = '';
    let subtotal = 0;

    cart.forEach(item => {
        let price = Number(item.price) || 0;
        let qty = parseInt(item.qty) || 1;
        let productSubtotal = price * qty;

        subtotal += productSubtotal;

        const li = document.createElement('li');
        li.innerHTML = `
            <img src="${item.img || '/images/no-image.png'}" alt="${item.name}">
            <div class="product-info">
                ${item.name}<br>
                ${item.size ? 'Size: ' + item.size + '<br>' : ''}
                ${item.color ? 'Color: ' + item.color + '<br>' : ''}
                Price: BDT ${productSubtotal.toFixed(2)}
                <div class="qty-btns">
                    <button class="decrease" data-id="${item.id}" data-size="${item.size || ''}" data-color="${item.color || ''}">-</button>
                    <span>${qty}</span>
                    <button class="increase" data-id="${item.id}" data-size="${item.size || ''}" data-color="${item.color || ''}">+</button>
                </div>
            </div>
            <button class="removeBtn" data-id="${item.id}" data-size="${item.size || ''}" data-color="${item.color || ''}">├Ч</button>
        `;
        cartList.appendChild(li);
    });

    cartItems.textContent = cart.reduce((sum, i) => sum + (Number(i.qty) || 1), 0);

     let totalAmount = subtotal;
    //cartTotal.textContent = `Subtotal: BDT ${subtotal.toFixed(2)} | Total: BDT ${totalAmount.toFixed(2)}`;
    cartTotal.textContent = `${totalAmount.toFixed(2)}`;

    if (cart.length === 0 && returnShop) returnShop.style.display = 'inline-block';
    else if (returnShop) returnShop.style.display = 'none';

    // Remove
    document.querySelectorAll('.removeBtn').forEach(btn => {
        btn.addEventListener('click', e => {
            const id = e.target.dataset.id;
            const size = e.target.dataset.size || null;
            const color = e.target.dataset.color || null;
            cart = cart.filter(item => !(item.id == id && item.size == size && item.color == color));
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
            updateCartCounts();
        });
    });

    // Increase
    document.querySelectorAll('.increase').forEach(btn => {
        btn.addEventListener('click', e => {
            const id = e.target.dataset.id;
            const size = e.target.dataset.size || null;
            const color = e.target.dataset.color || null;
            let item = cart.find(i => i.id == id && i.size == size && i.color == color);
            if (item) item.qty++;
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
            updateCartCounts();
        });
    });

    // Decrease
    document.querySelectorAll('.decrease').forEach(btn => {
        btn.addEventListener('click', e => {
            const id = e.target.dataset.id;
            const size = e.target.dataset.size || null;
            const color = e.target.dataset.color || null;
            let item = cart.find(i => i.id == id && i.size == size && i.color == color);
            if (item) {
                if (item.qty > 1) item.qty--;
                else cart = cart.filter(i => !(i.id == id && i.size == size && i.color == color));
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
            updateCartCounts();
        });
    });

    updateCartCounts();
}


document.addEventListener('click', function (e) {
  if (e.target.closest('.addToCart')) {
    const btn = e.target.closest('.addToCart');
    const id = btn.dataset.id;
    const name = btn.dataset.name;
    const img = btn.dataset.img || document.getElementById('mainImage')?.src || '/images/no-image.png';
    
    // Price fix: 1 decimal
    let price = parseFloat(btn.dataset.price.replace(/,/g, '')) || 0;
    price = parseFloat(price.toFixed(1));

    // For Related Products (list), get barcode from product_barcode attribute if exists
    const barcode = btn.dataset.barcode || btn.dataset.selectedBarcode || btn.dataset.productBarcode || 'NO_BARCODE';

    // Sizes/Colors: list ржерзЗржХрзЗ рж╣рж▓рзЗ null
    const size = btn.dataset.size || btn.dataset.selectedSize || null;
    const color = btn.dataset.color || btn.dataset.selectedColor || null;

    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let existing = cart.find(item => item.id == id && item.size == size && item.color == color);

    if (existing) existing.qty++;
    else cart.push({ id, name, price, img, size, color, qty: 1, barcode });

    localStorage.setItem('cart', JSON.stringify(cart));
    renderCart();
    updateCartCounts();

    document.getElementById('cartSidebar')?.classList.add('active');
    document.getElementById('cartOverlay')?.classList.add('active');
  }
});






// Cart sidebar toggle
document.getElementById('closeCart')?.addEventListener('click', () => {
  document.getElementById('cartSidebar')?.classList.remove('active');
  document.getElementById('cartOverlay')?.classList.remove('active');
});



// Wishlist
/*const wishlistCountEls = document.querySelectorAll(".wishlist-count");
function getWishlistCount() { return parseInt(localStorage.getItem("wishlistCount")) || 0; }
function updateWishlistUI(count) { wishlistCountEls.forEach(el => el.textContent = count); }
updateWishlistUI(getWishlistCount());
document.querySelectorAll(".wish-btn").forEach(btn => {
  btn.addEventListener("click", () => {
    const icon = btn.querySelector("i");
    let count = getWishlistCount();
    if (icon.classList.contains("far")) { icon.classList.replace("far", "fas"); count++; }
    else { icon.classList.replace("fas", "far"); if(count>0) count--; }
    localStorage.setItem("wishlistCount", count);
    updateWishlistUI(count);
  });
});*/


// Wishlist
const wishlistCountEls = document.querySelectorAll(".wishlist-count");

function getWishlist() {
  return JSON.parse(localStorage.getItem("wishlist")) || [];
}

function setWishlist(data) {
  localStorage.setItem("wishlist", JSON.stringify(data));
  updateWishlistCount();
}

function updateWishlistCount() {
  const count = getWishlist().length;
  wishlistCountEls.forEach(el => el.textContent = count);
}

updateWishlistCount();

// Toggle wishlist
document.querySelectorAll(".wish-btn").forEach(btn => {
  btn.addEventListener("click", function () {
    const icon = this.querySelector("i");
    let wishlist = getWishlist();

    const product = {
      id: this.dataset.id,
      name: this.dataset.name || 'Product',
      price: this.dataset.price || 0,
      img: this.dataset.img || '/assets/images/no-image.png',
      slug: this.dataset.slug || '#',
      stock_status: this.dataset.stockStatus || 'Y', // optional
      sale_price: this.dataset.salePrice || null // optional
    };

    const exists = wishlist.find(p => p.id === product.id);

    if (!exists) {
      wishlist.push(product);
      icon.classList.replace("far", "fas");
    } else {
      wishlist = wishlist.filter(p => p.id !== product.id);
      icon.classList.replace("fas", "far");
    }

    setWishlist(wishlist);
  });
});

// ===============================
// Swiper Sliders
// ===============================
function initSwiper(className){
  return new Swiper(className, {
    slidesPerView: 1,
    spaceBetween: 4,
    loop: true,
    speed: 800,
    autoplay: { delay: 3000, disableOnInteraction: false },
    navigation: {
      nextEl: className+' .swiper-button-next',
      prevEl: className+' .swiper-button-prev'
    },
    breakpoints: {
      576: { slidesPerView: 2, spaceBetween: 4 },
      768: { slidesPerView: 3, spaceBetween: 4 },
      992: { slidesPerView: 4, spaceBetween: 4 }
    }
  });
}

// Main Swipers
let swiperShoes = initSwiper('.mySwiperShoes');
let swiperSix = new Swiper('.mySwiperSix', {
  slidesPerView: 2,
  spaceBetween: 4,
  loop: true,
  speed: 800,
  autoplay: { delay: 3000, disableOnInteraction: false },
  navigation: { nextEl: '.mySwiperSix .swiper-button-next', prevEl: '.mySwiperSix .swiper-button-prev' },
  breakpoints: {
    576: { slidesPerView: 3, spaceBetween: 4 },
    768: { slidesPerView: 4, spaceBetween: 4 },
    992: { slidesPerView: 5, spaceBetween: 4 },
    1200: { slidesPerView: 6, spaceBetween: 4 }
  }
});

// Tab-based sliders
document.querySelectorAll('button[data-bs-toggle="tab"]').forEach(tab => {
  tab.addEventListener('shown.bs.tab', e => {
    const target = e.target.getAttribute('data-bs-target');
    if(target === '#tab2' && window.swiperBags) window.swiperBags.update();
    if(target === '#tab3' && window.swiperWatches) window.swiperWatches.update();
  });
});

// ===============================
// Initial Render
// ===============================
renderCart();
updateCartCounts();


// Open Cart
document.getElementById('openCart')?.addEventListener('click', () => {
  document.getElementById('cartSidebar')?.classList.add('active');
  document.getElementById('cartOverlay')?.classList.add('active');
});

// Close Cart
document.getElementById('closeCart')?.addEventListener('click', () => {
  document.getElementById('cartSidebar')?.classList.remove('active');
  document.getElementById('cartOverlay')?.classList.remove('active');
});

// Click on overlay to close cart
document.getElementById('cartOverlay')?.addEventListener('click', () => {
  document.getElementById('cartSidebar')?.classList.remove('active');
  document.getElementById('cartOverlay')?.classList.remove('active');
});

// Close function
function closeEmptyCartModal() {
  $("#emptyCartModal").modal("hide");
}

//cart validation
document.addEventListener('DOMContentLoaded', function () {
    const cartBtn = document.getElementById('cartBtn');
    if (!cartBtn) return;

    cartBtn.addEventListener('click', function () {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        if (cart.length > 0) {
            window.location.href = chartUrl; // Laravel route ржерзЗржХрзЗ ржЖрж╕рж╛ URL
        } else {
            showEmptyCartModal();
        }
    });
});

// ржоржбрж╛рж▓ ржжрзЗржЦрж╛ржирзЛрж░ ржлрж╛ржВрж╢ржи
function showEmptyCartModal() {
    const modal = document.getElementById('emptyCartModal');
    if(modal) modal.classList.add('show');
    modal.style.display = 'block';
    modal.setAttribute('aria-modal', 'true');
    modal.removeAttribute('aria-hidden');
}

// ржоржбрж╛рж▓ ржмржирзНржз ржХрж░рж╛рж░ ржлрж╛ржВрж╢ржи
function closeEmptyCartModal() {
    const modal = document.getElementById('emptyCartModal');
    if(modal) {
        modal.classList.remove('show');
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');
        modal.removeAttribute('aria-modal');
    }
}


document.getElementById('checkoutBtn')?.addEventListener('click', function(e) {
    e.preventDefault();
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const url = this.dataset.url; // Blade থেকে route

    if(cart.length === 0){
        // Empty cart modal দেখাও
        showEmptyCartModal();
    } else {
        // Redirect to checkout
        window.location.href = url;
    }
});



 