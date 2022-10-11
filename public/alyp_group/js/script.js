// MENU TOGGLE BURGER
$(document).ready(function () {
  $('.header-burger').click(function (event) {
      $('.header-burger,.header-menu').toggleClass('active');
      $('body').toggleClass('lock');
  });
});

$(document).ready(function() {
  $('.header__link').click(function(event) {
    $('body').removeClass('lock');
    $('.header-burger,.header-menu').removeClass('active');
  })
});



// SLIDERS
// 1. OWNERS
var ownersSwiper = new Swiper(".ownersSwiper", {
  spaceBetween: 30,
  loop: 0,
  breakpoints: {
    1024: {
      slidesPerView: 4,
    },
    991: {
      slidesPerView: 3,
    },
    768: {
      slidesPerView: 2,
    },
    0: {
      slidesPerView: 1,
    },
  },
  navigation: {
    nextEl: ".swiper-button-next-1",
    prevEl: ".swiper-button-prev-1",
  },
});
// 2. COFOUNDER
var cofounderSwiper = new Swiper(".cofounderSwiper", {
  spaceBetween: 30,
  loop: 0,
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
  },
  navigation: {
    nextEl: ".swiper-button-next-2",
    prevEl: ".swiper-button-prev-2",
  },
});

