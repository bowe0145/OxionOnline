var main = function() {

NewsPatchHandler(1);
CheckServerStatus();

// Get the slide count
  var slideCount = $('.slide').length;
  
  for (var i = 0; i < slideCount; i++) {
    if (i === 0) {
      $('.dotHolder').append("<div class='dot active-dot'></div>");
    }
    else {
      $('.dotHolder').append("<div class='dot'></div>");
    }
  }
  
    for (var i = 0; i < slideCount; i++) {
        console.log($('.dotHolder').index('.dot'));
    };

    var interval = setInterval(function() {
      Carousel(0);
    }, 5000);
  
    $('.arrow-next').click(function() {
        clearInterval(interval);
        setTimeout(function() {
          interval = setInterval(function() {
            Carousel(0);
          }, 5000);
        });
        Carousel(0);
    });
    
    $('.arrow-prev').click(function() {
        clearInterval(interval);
        setTimeout(function() {
          interval = setInterval(function() {
            Carousel(0);
          }, 5000);
        });
        Carousel(1);
    });
    
    $('.PatchTitle').click(function() {
      NewsPatchHandler(0);
    });
    
    $('.NewsTitle').click(function() {
      NewsPatchHandler(1);
    });
};

var Carousel = function(type) {
  if (type === 0) {
    // Go forward
    var currentSlide = $('.active-slide');
    var nextSlide = currentSlide.next();

    var currentDot = $('.active-dot');
    var nextDot = currentDot.next();

    if(nextSlide.length === 0) {
      nextSlide = $('.slide').first();
      nextDot = $('.dot').first();
    }

    currentSlide.fadeOut(600).removeClass('active-slide');
    nextSlide.fadeIn(600).addClass('active-slide');

    currentDot.removeClass('active-dot');
    nextDot.addClass('active-dot');
  }
  else if (type === 1) {
    // Go backwards
    var currentSlide = $('.active-slide');
    var prevSlide = currentSlide.prev();
    
    var currentDot = $('.active-dot');
    var prevDot = currentDot.prev();
    
    if (prevSlide.length === 0) {
        prevSlide = $('.slide').last();
        prevDot = $('.dot').last();
    }
    
    currentSlide.fadeOut(600).removeClass('active-slide');
    prevSlide.fadeIn(600).addClass('active-slide');
    
    currentDot.removeClass('active-dot');
    prevDot.addClass('active-dot');
  }
}

var NewsPatchHandler = function(type) {
  if (type === 0) {
    if ($('.PatchTitle').hasClass('ActiveTitle') !== true) {
        $('.NewsTitle').removeClass('ActiveTitle');
        $('.PatchTitle').addClass('ActiveTitle');
        $('.PatchTitle').insertBefore($('.NewsTitle'));
    }
    $('.Container').load('../News/Patches/Patch.html');
  }
  else if (type === 1) {
    if ($('.NewsTitle').hasClass('ActiveTitle') !== true) {
        $('.PatchTitle').removeClass('ActiveTitle');
        $('.NewsTitle').addClass('ActiveTitle');
        $('.NewsTitle').insertBefore($('.PatchTitle'));
    }
    $('.Container').load('../News/News/News.html');
  }
}

var loadTopPlayers = function() {
    $("#TopPlayers").load('../UserCP/handler.php?top10p');
}

var loadGuide = function(guide) {
  if($("#GuideContainer").length == 0) {
    console.log("No Guide Container");
  }
  else {
    console.log("Loading guide" + guide);
    $("#GuideContainer").load("Guides/" + guide, function( response, status, xhr) {
        if (status == "error") {
            var msg = "Sorry but there was an error: ";
            $("#GuideContainer").html(msg + xhr.status + " " + xhr.statusText + " " + guide);
        }
      });
  }
}

var CheckServerStatus = function() {
  console.log("Called it");
  $StatusDiv = $('#ServerStatus h2');
    $.get("../server.txt", function(data) {
      if (data.toLowerCase().indexOf("online") >= 0)
      {
        $($StatusDiv).text('Online');
        $($StatusDiv).removeClass('offline');
        $($StatusDiv).addClass('online');
      }
      else
      {
        $($StatusDiv).text('Offline');
        $($StatusDiv).removeClass('online');
        $($StatusDiv).addClass('offline');
      }
      console.log(data);
    });
}

$(document).ready(main);
$(document).ready(loadTopPlayers);
$(document).ready(loadGuide("Basics.php"));

$(document).on('click', 'a[href^="#"]', function(e) {
    // target element id
    var id = $(this).attr('href');

    // target element
    var $id = $(id);
    if ($id.size() === 0) {
        return;
    }

    // prevent standard hash navigation (avoid blinking in IE)
    e.preventDefault();

    // top position relative to the document
    var pos = $(id).offset().top;

    // animated top scrolling
    $('body, html').animate({scrollTop: pos-100});
});