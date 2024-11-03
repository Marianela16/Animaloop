$(document).ready(function () {
  const $window = $(window);
  const $document = $(document);
  const $body = $("body");
  const $html = $("html");

  function ajustarAlturas() {
    if ($window.width() <= 992) {
      var maxAlturaNombre = 0;
      var alturaDescripBase = 0;
      var bloques = $(".banner.banner-slider .banner-block");

      bloques.each(function () {
        var alturaNombre = $(this).find(".anime-nombre").outerHeight(true);
        if (alturaNombre > maxAlturaNombre) {
          maxAlturaNombre = alturaNombre;
          alturaDescripBase = $(this).find(".anime-descrip").outerHeight(true);
        }
      });

      bloques.each(function () {
        var $this = $(this);
        var $nombre = $this.find(".anime-nombre");
        var $descrip = $this.find(".anime-descrip");
        var alturaNombre = $nombre.outerHeight(true);

        if (alturaNombre < maxAlturaNombre) {
          var diferenciaNombre = maxAlturaNombre - alturaNombre;
          $descrip.css(
            "min-height",
            `calc(${alturaDescripBase}px + ${diferenciaNombre}px)`
          );
        } else {
          $descrip.css("min-height", "");
        }
      });
    } else {
      $(".banner.banner-slider .banner-block .anime-descrip").css(
        "min-height",
        ""
      );
    }
  }

  function mostrarAnchoPantalla() {
    var anchoPantalla = window.innerWidth;
    var elemento = document.querySelector('.size');
    if (elemento) {
      elemento.textContent = `Ancho de la pantalla: ${anchoPantalla}px`;
    }
  }

  function recalcularAltura() {
    if ($window.width() >= 992) {
      $(".banner.banner-slider .banner-block").each(function () {
        var $this = $(this);
        var alturaTotal = $this.find(".banner-img").outerHeight(true);
        var alturaOcupada = [
          ".anime-nombre",
          ".etiq",
          ".anime-play"
        ].reduce((sum, selector) => sum + $this.find(selector).outerHeight(true), 0);
  
        var alturaDisponible = Math.max(0, alturaTotal - alturaOcupada);
  
        $this.find(".anime-descrip").css("max-height", alturaDisponible + "px");
      });
    } else {
      $(".banner.banner-slider .banner-block .anime-descrip").css("max-height", "");
    }
  }

  function onScroll() {
    var btn = $("#backto-top");
    if ($window.scrollTop() > 300) {
      btn.addClass("show");
    } else {
      btn.removeClass("show");
    }
  }

  function backToTop() {
    var btn = $("#backto-top");
    btn.on("click", function (e) {
      e.preventDefault();
      $("html, body").animate({ scrollTop: 0 }, 300);
    });
  }

  function preloader() {
    setTimeout(function () {
      $("#preloader").hide();
    }, 2000);
  }

  function countdownInit(countdownSelector, countdownTime) {
    var eventCounter = $(countdownSelector);
    if (eventCounter.length) {
      eventCounter.countdown(countdownTime, function (e) {
        if ($(".data-timer1").length) {
          $(this).html(
            e.strftime(
              "<li>%D <small>Días</small></li><li>%H <small>Hrs</small></li><li>%M <small>Min</small></li><li>%S <small>Seg</small></li>"
            )
          );
        }
        if ($(".data-timer2").length) {
          $(this).html(
            e.strftime(
              '<li>%D<span>Días</span></li><li>%H<span>Hrs</span></li><li>%M<span>Min</span></li><li class="m-0">%S<span>Seg</span></li>'
            )
          );
        }
      });
    }
  }
  $(document).on("click", function (event) {
    if (!$(event.target).closest(".has-children").length) {
      $(".has-children").children("ul").hide();
      $(".icon-arrow").removeClass("open");
    }
  });

  $(".has-children").on("click", function (event) {
    event.stopPropagation();
    $(".has-children").not(this).children("ul").hide();
    $(this).children("ul").slideToggle(400, "swing");
    $(this).find(".icon-arrow").toggleClass("open");
    $(".has-children").not(this).find(".icon-arrow").removeClass("open");
  });
  function initializeSlick() {
    if ($(".card-slider").length) {
      $(".card-slider").slick({
        infinite: true,
        slidesToShow: 5,
        slidesToScroll: 1,
        arrows: true,
        dots: false,
        autoplay: true,
        autoplaySpeed: 3000,
        responsive: [
          {
            breakpoint: 992,
            settings: { slidesToShow: 4 },
          },
          {
            breakpoint: 768,
            settings: { slidesToShow: 3 },
          },
          {
            breakpoint: 576,
            settings: { slidesToShow: 2 },
          },
        ],
      });
    }
  }

  function initialize() {
    $window.on("scroll", onScroll);
    ajustarAlturas();
    recalcularAltura();
    mostrarAnchoPantalla();
    backToTop();
    preloader();
    countdownInit(".countdown", "2024/12/30");
    initializeSlick();
  }

  const observer = new ResizeObserver(() => {
    ajustarAlturas();
    recalcularAltura();
    mostrarAnchoPantalla();
  });
  observer.observe(document.body);

  $window.on("orientationchange", function () {
    ajustarAlturas();
    recalcularAltura();
    mostrarAnchoPantalla();
  });

  initialize();
});