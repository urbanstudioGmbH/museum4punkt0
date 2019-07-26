
"use strict";

(function ($, PIXI) {

  var requestAnimationFrame = window.requestAnimationFrame;
  var cancelAnimationFrame = window.cancelAnimationFrame;

  var width;
  var height;
  var scrollWrapper = null;
  var displayWrapper = null;
  var renderer = null;
  var stage = null;
  var mainContainer = null;
  var layers = {};
  var controller = new ScrollMagic.Controller();
  var scenes = {};
  var trigger = {};
  var scrollFactor = 2;
  var textScrollFactor = 0;

  function onReady() {

    var StickyFallBack = $('.hero-content');
    Stickyfill.add(StickyFallBack);

    scrollWrapper = $('.scroll-content')[0];

    if (!scrollWrapper) {
      return;
    }

    displayWrapper = $('.hero-content')[0];

    var view = $('.animation')[0];

    $('.skipIntro-label').on('click', function () {
      controller.scrollTo(function (newScrollPos) {
        $("html, body").animate({
          scrollTop: newScrollPos
        },1500, 'easeOutExpo');
      });
      // Add one pixel to enter trigger zone, so 'enter' and 'leave' work as expected
      var winHeight = $(window).height();
      var scrollIntro = (winHeight/4) * 3;
      controller.scrollTo(scenes.text1.scrollOffset() + scrollIntro); // original: + 1

      return false;
    });

    // possible TODOs:
    // 1. extract Animation object: new ScrollAnimation (scrollWrapper, scrollFactor);
    // 2. extract helper functions
    // 3. simplify ani

    // renderer = new PIXI.CanvasRenderer ( {
    renderer = PIXI.autoDetectRenderer({
      roundPixels: true,
      resolution: window.devicePixelRatio || 1,
      view: view,
      transparent: false
      // forceFXAA: true

    });

    // for touch devices (don't catch events and let the in browser scrolling work)
    renderer.view.style['touch-action'] = 'auto';
    renderer.plugins.interaction.autoPreventDefault = false;

    var isWebGL = renderer instanceof PIXI.WebGLRenderer;
    var useSVG;
    var textureScale;

    if (!isWebGL) {
      // no webgl ? probalby no SVG either !
      useSVG = false;
      textureScale = 4;
      renderer.context.imageSmoothingEnabled = false;
      renderer.context.mozImageSmoothingEnabled = false;
      renderer.context.webkitImageSmoothingEnabled = false;
    } else {
      var webglContext = renderer.view.getContext("webgl");
      useSVG = true;
      textureScale = 1;

      if (!webglContext) {
        // old web implemenation using experimental-webgl ?
        // probalby no SVG either !
        webglContext = renderer.view.getContext("experimental-webgl");
        useSVG = false;
      }

      // use MAX_TEXTURE_SIZE to detect textureScale 
      if (webglContext) {
        var MAX_TEXTURE_SIZE = webglContext.getParameter(webglContext.MAX_TEXTURE_SIZE);
        if (MAX_TEXTURE_SIZE >= 8000) {
          textureScale = 4;
        } else if (MAX_TEXTURE_SIZE >= 4000) {
          textureScale = 2;
        }
      }
    }

    /*
     * Fix for iOS GPU issues
     */
    renderer.view.style['transform'] = 'translatez(0)';

    PIXI.settings.SCALE_MODE = PIXI.SCALE_MODES.NEAREST;

    stage = new PIXI.Container();
    mainContainer = new PIXI.Container();
    stage.addChild(mainContainer);

    renderer.backgroundColor = 0xFFFFFF;

    var loader = PIXI.loader; // PixiJS exposes a premade instance for you to use.
    var textures = {};
    var imageSuffix = useSVG ? '.svg' : '.png';

    loader.add('layer1', '/wp-content/themes/museum4punkt0/images/homeani/ebene1-' + Math.min(textureScale, 2) + imageSuffix);
    loader.add('layer2', '/wp-content/themes/museum4punkt0/images/homeani/ebene2-' + textureScale + imageSuffix);
    loader.add('layer3', '/wp-content/themes/museum4punkt0/images/homeani/ebene3-' + textureScale + imageSuffix);

    loader.load(function (loader, resources) {
      textures.layer1 = resources.layer1.texture;
      textures.layer2 = resources.layer2.texture;
      textures.layer3 = resources.layer3.texture;

      layers.layer1 = new PIXI.Sprite(textures.layer1);
      layers.layer2 = new PIXI.Sprite(textures.layer2);
      layers.layer3 = new PIXI.Sprite(textures.layer3);

      scenes.layer1 = new ScrollMagic.Scene().addTo(controller);
      scenes.layer2 = new ScrollMagic.Scene().addTo(controller);
      scenes.layer3 = new ScrollMagic.Scene().addTo(controller);

      // TODO: extract addTextAnimations(".animated-heading", ".animated-heading--active")
      trigger.text1 = $("<div>").attr('id', 'text-trigger-1').addClass('scrollmagic-trigger');
      $(scrollWrapper).append(trigger.text1);
      //trigger.text2 = $("<div>").attr('id', 'text-trigger-2').addClass('scrollmagic-trigger');
      //$(scrollWrapper).append(trigger.text2);

      scenes.text1 = new ScrollMagic.Scene({ triggerElement: '#text-trigger-1' }).addTo(controller);
      //scenes.text2 = new ScrollMagic.Scene({triggerElement: '#text-trigger-2'}).addTo(controller);

      // add textanimation
      function showAndScrambleText(selector) {
        var activeClass = 'animated-heading--active';
        var sequence = $(selector);

        if (sequence.length > 0) {
          var current = $(sequence.splice(0, 1));

          current.children().shuffleLetters({ callback: function callback() {
              showAndScrambleText(sequence);
            } });
          current.addClass(activeClass);
        }
      }

      function toggleBackgroundActiveState(toggle) {
        $('.animated-background').toggleClass('animated-background--active', toggle);
      }

      scenes.text1.on("enter leave", function (e) {
        //toggleBackgroundActiveState(e.type === 'enter');
        var scrollDirection = e.target.controller().info("scrollDirection");
        if (e.type === 'enter') {
          toggleBackgroundActiveState(false);
          //scrollDirection !== "REVERSE" && showAndScrambleText("h1.animated-heading, h2.animated-heading");
          $('.skipIntro').addClass('skipIntro--hidden');
        } else if (scrollDirection !== "FORWARD") {
          toggleBackgroundActiveState(false);
          $("h1.animated-heading, h2.animated-heading").removeClass('animated-heading--active');
          $('.skipIntro').removeClass('skipIntro--hidden');
        }
      });

      resizeHandler();

      view.style.visibility = 'visible';
      displayWrapper.classList.remove("display-content--blurred");
      // kick off the animation loop (defined below)
      animate();
    });
  };

  function resizeHandler() {
    width = renderer.view.offsetWidth;
    height = renderer.view.offsetHeight;

    mainContainer.removeChildren();
    initLayers();

    scrollWrapper.style.height = 100 * (scrollFactor + textScrollFactor + 1) + 'vh';

    trigger.text1.css('top', 100 * (scrollFactor + 0.5) + 'vh');
    //trigger.text2.css('top', 100 * (scrollFactor+0.5 + textScrollFactor/2) + 'vh');

    var duration = renderer.view.offsetHeight * (textScrollFactor / 2); // change on resize
    scenes.text1.duration(duration);
    // last text scene stays
    // scenes.text2.duration(duration);

    controller.update(true);
    renderer.resize(width, height);
    // animate();
  }

  function initLayers() {
    addLayer(scenes.layer2, layers.layer2, 13.8, 1 / 13.8);
    addLayer(scenes.layer3, layers.layer3, 210, 1);
    addLayer(scenes.layer1, layers.layer1, 1, 1 / 210);

    // adjust scrolling duration and length
    // if it would be relative to viewport height (%, vh), the animation would jump when the browser toogles control
    // elements and thus changing viewport size.

    var duration = renderer.view.offsetHeight * scrollFactor; // change on resize
    scenes.layer1.duration(duration);
    scenes.layer2.duration(duration);
    scenes.layer3.duration(duration);
  }

  function addLayer(scene, layer, startFactor, endFactor) {

    var cScale = coverScale(layer);
    var startScale = cScale * startFactor;
    var targetScale = cScale * endFactor;

    layer.position.x = width / 2;
    layer.position.y = height / 2;
    layer.anchor.set(0.5);
    layer.scale.x = startScale;
    layer.scale.y = startScale;
    mainContainer.addChild(layer); // TODO: if performance problems on resize, the items could be recycled

    scene.removeTween();
    var tween = TweenLite.to(layer, 1, { pixi: { scaleX: targetScale, scaleY: targetScale } });
    scene.setTween(tween);
  }

  function animate() {
    // start the timer for the next animation loop
    requestAnimationFrame(animate);
    renderer.render(stage);
  };

  var resizeRequest;
  function delayedResize() {
    if (resizeRequest) clearTimeout(resizeRequest);
    resizeRequest = setTimeout(resizeHandler, 200);
  }

  $(document).ready(onReady);
  $(window).resize(delayedResize);
  window.addEventListener('orientationchange', delayedResize);

  // helper functions

  function containSize(layer) {
    var ratio = layer.texture.width / layer.texture.height;

    var imageWidth;
    var imageHeight;

    if (ratio >= 1) {
      // landscape
      imageWidth = width;
      imageHeight = imageWidth / ratio;
      if (imageHeight > height) {
        imageHeight = height;
        imageWidth = height * ratio;
      }
    } else {
      // portrait
      imageHeight = height;
      imageWidth = imageHeight * ratio;
      if (imageWidth > areaWidth) {
        imageWidth = width;
        imageHeight = width / ratio;
      }
    }
    return { height: imageHeight, width: imageWidth };
  }

  function coverSize(layer) {
    var ratio = layer.texture.width / layer.texture.height;
    var imageWidth;
    var imageHeight;

    if (ratio >= 1) {
      // landscape
      imageWidth = width;
      imageHeight = imageWidth / ratio;
      if (imageHeight < height) {
        imageHeight = height;
        imageWidth = height * ratio;
      }
    } else {
      // portrait
      imageHeight = height;
      imageWidth = imageHeight * ratio;
      if (imageWidth < areaWidth) {
        imageWidth = width;
        imageHeight = width / ratio;
      }
    }
    return { height: imageHeight, width: imageWidth };
  }

  function coverScale(layer) {
    var size = coverSize(layer);
    return size.height / layer.texture.height;
  }
})(window.jQuery, window.PIXI);
