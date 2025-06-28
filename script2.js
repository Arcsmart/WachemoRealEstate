/* ---------slider------- */
 $(document).ready(function () {
   $(".hero-slider").slick({
     autoplay: true,
     infinite: false,
     speed: 100,
     nextArrow: $(".next"),
     prevArrow: $(".prev"),
   });
 });
 
 $(document).ready(function () {
   $(".testimonal-slider").slick({
     autoplay: true,
     infinite: false,
     speed: 200,
     nextArrow: $(".next1"),
     prevArrow: $(".prev1"),
   });
 });
 

var head = document.querySelector("header");
console.log("head element", head);
function fixedNavbar() {
  if (head) {
    head.classList.toggle("scrolled", window.pageYOffset > 0);
  } else {
  }
}

if (head) {
  fixedNavbar();
  window.addEventListener("scroll", fixedNavbar);
}

var menu = document.querySelector("#menu-btn");
console.log("menu element", menu);
var userBtn = document.querySelector("#user-btn");
console.log("userBtn element", userBtn);

if (menu) {
  menu.addEventListener("click", function () {
    var nav = document.querySelector(".navbar");

    if (nav.style.maxHeight) {
      nav.style.maxHeight = null;
      nav.style.opacity = 0;
      setTimeout(() => nav.classList.remove("active"), 500);
    } else {
      nav.classList.add("active");
      nav.style.maxHeight = nav.scrollHeight + "px";
      nav.style.opacity = 1;
    }
  });
}
if (userBtn) {
  userBtn.addEventListener("click", function () {
    var userBox = document.querySelector(".user-box");
    userBox.classList.toggle("active");
  });
}

// Add this to your existing JavaScript
document.querySelectorAll(".edit-btn").forEach((button) => {
  button.addEventListener("click", () => {
    document.querySelector(".update-container").style.display = "flex";
  });
});

var closeBtn = document.querySelector("#close-form");
if (closeBtn) {
  closeBtn.addEventListener("click", () => {
    var updateContainer = document.querySelector(".update-container");
    if (updateContainer) {
      updateContainer.style.display = "none";
    }
  });
}
