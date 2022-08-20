//DROPDOWN
var togg = $('.dropdown');
$('.dropdown-btn', togg).click(function (event) {
    event.preventDefault();
    var self = $(this);
    var toggle = self.closest('.dropdown');
    toggle.toggleClass('open');
    var slide = toggle.find('.dropdown-menu');
    slide.slideToggle(400, function () {
        slide.find('input:first').focus();
    });
});
$(document).mouseup(function (e) {
    if (!togg.is(e.target) && togg.has(e.target).length === 0 && togg.hasClass('open')) {
        togg.removeClass('open').find('.dropdown-menu').slideUp(400);
    }
});
//DROPDOWN-END

//SWIPER
const mainSlider = new Swiper(".main-slider", {
    // spaceBetween: 10,
    autoplay: {
        delay: 10000,
        disableOnInteraction: false,
        waitForTransition: false,
    },
    slidesPerView: 1,
    speed: 1500,
    loop: true,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    }
});

var swiper = new Swiper(".specialists-slider", {
    autoplay: {
        delay: 10000,
        disableOnInteraction: false,
        waitForTransition: false,
    },
    speed: 1000,
    effect: "fade",
    noSwiping: true,
    noSwipingClass: 'swiper-slide',
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
  });
//SWIPER-END

//IMASK

    // var showHideSnilsMask = document.getElementById('snilsMask');
    // var snilsMask = new IMask(showHideSnilsMask, {
    //     mask: '000-000-000 00',
    //     lazy: true,  // make placeholder always visible
    //     placeholderChar: '_'     // defaults to '_'
    // });
    // showHideSnilsMask.addEventListener('focus', function() {
    //     snilsMask.updateOptions({ lazy: false });
    // }, true);
    // showHideSnilsMask.addEventListener('blur', function() {
    //     snilsMask.updateOptions({ lazy: true });
    //         // NEXT IS OPTIONAL
    //     if (!snilsMask.masked.rawInputValue) {
    //         snilsMask.value = '';
    //     }
    // }, true);

    // var showHidePhoneMask = document.getElementById('phoneMask');
    // var phoneMask = new IMask(showHidePhoneMask, {
    //     mask: '+{7} (000) 000-00-00',
    //     lazy: true,  // make placeholder always visible
    //     placeholderChar: '_'     // defaults to '_'
    // });
    // showHidePhoneMask.addEventListener('focus', function() {
    //     phoneMask.updateOptions({ lazy: false });
    // }, true);
    // showHidePhoneMask.addEventListener('blur', function() {
    //     phoneMask.updateOptions({ lazy: true });
    //         // NEXT IS OPTIONAL
    //     if (!phoneMask.masked.rawInputValue) {
    //         phoneMask.value = '';
    //     }
    // }, true);

    var inpTel = document.querySelectorAll('input#phoneNumber[type=tel]');
    var mask;
    for(var i = 0; i < inpTel.length; i++) {
      inpTel[i].addEventListener('focus', function(){
        mask = IMask(this, {
            mask: '+{7} (000) 000-00-00',
            overwrite: true,
            lazy: false,
            autofix: true
        });
      })
      inpTel[i].addEventListener('blur', function(){
        if(this.value.match('_')){
          mask.masked.reset()
        }
      })
    };

    var inpTel = document.querySelectorAll('input#passportSeriesMask[type=tel]');
    var mask;
    for(var i = 0; i < inpTel.length; i++) {
      inpTel[i].addEventListener('focus', function(){
        mask = IMask(this, {
            mask: '0000',
            overwrite: true,
            lazy: false,
            autofix: true
        });
      })
      inpTel[i].addEventListener('blur', function(){
        if(this.value.match('_')){
          mask.masked.reset()
        }
      })
    };

    var inpTel = document.querySelectorAll('input#passportNumberMask[type=tel]');
    var mask;
    for(var i = 0; i < inpTel.length; i++) {
      inpTel[i].addEventListener('focus', function(){
        mask = IMask(this, {
            mask: '000000',
            overwrite: true,
            lazy: false,
            autofix: true
        });
      })
      inpTel[i].addEventListener('blur', function(){
        if(this.value.match('_')){
          mask.masked.reset()
        }
      })
    };

//IMASK-END

// SHOW / HIDE PASSWORD

$(".toggle-password").click(function () {
    $(this).toggleClass("hide_password");
    //Apelsin reg
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }

    //custom reg
    var new_input = $(this).closest('.input-pass').find('input');
    if (new_input.attr("type") == "password") {
        new_input.attr("type", "text");
    } else {
        new_input.attr("type", "password");
    }

});

// SHOW / HIDE PASSWORD-END

//CUSTOM-SELECT

$(".custom-select").each(function() {
    var classes = $(this).attr("class"),
        id      = $(this).attr("id"),
        name    = $(this).attr("name");
    var template =  '<div class="' + classes + '">';
        template += '<span class="custom-select-trigger">' + $(this).attr("placeholder") + '</span>';
        template += '<div class="custom-options">';
        $(this).find("option").each(function() {
            template += '<span class="custom-option ' + $(this).attr("class") + '" data-value="' + $(this).attr("value") + '">' + $(this).html() + '</span>';
        });
    template += '</div></div>';

    $(this).wrap('<div class="custom-select-wrapper"></div>');
    $(this).hide();
    $(this).after(template);
});
$(".custom-option:first-of-type").hover(function() {
    $(this).parents(".custom-options").addClass("option-hover");    
}, function() {
    $(this).parents(".custom-options").removeClass("option-hover");
});
$(".custom-select-trigger").on("click", function() {
    $('html').one('click',function() {
        $(".custom-select").removeClass("opened");
    });
    $(this).parents(".custom-select").toggleClass("opened");
    event.stopPropagation();
});
$(".custom-option").on("click", function() {
    $(this).parents(".custom-select-wrapper").find("select").val($(this).data("value"));
    $(this).parents(".custom-options").find(".custom-option").removeClass("selection");
    $(this).addClass("selection");
    $(this).parents(".custom-select").removeClass("opened");
    $(this).parents(".custom-select").find(".custom-select-trigger").text($(this).text());
});

//CUSTOM-SELECT-END

//HELPER SHOW/HIDE
$('.show-helper').click(function() {
    $('.helper').show(0);
    $('.show-helper').hide(0);
    $('.hide-helper').show(0);
});
$('.hide-helper').click(function() {
    $('.helper').hide(0);
    $('.show-helper').show(0);
    $('.hide-helper').hide(0);
});
//HELPER SHOW/HIDE END

//MENU-BURGER
const iconMenu = document.querySelector('.mobile-menu-icon');
if (iconMenu) {
    const headerNav = document.querySelector('.desktop-link-list');
    iconMenu.addEventListener("click", function (e) {
        document.body.classList.toggle('lock');
        iconMenu.classList.toggle('active');
        headerNav.classList.toggle('active');
    });
}

//visually-impaired
const visuallyImpaired = document.querySelector('.visually-impaired');
if (visuallyImpaired) {
    visuallyImpaired.addEventListener("click", function (e) {
        document.body.classList.toggle('low-vision');
        visuallyImpaired.classList.toggle('active');
    });
}

//NEWS TOGGLE
$('.year-link').click(function(event) {
    event.preventDefault();
    $(this).parent().toggleClass('active');
    //$(this).next().toggle();
});