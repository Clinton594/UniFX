var $win = $(window), $body = $('body'), $doc = $(document);

// Touch Class
if (!("ontouchstart" in document.documentElement)) {
  $body.addClass("no-touch");
}
// Get Window Width
function winwidth() {
  return $win.width();
}
var wwCurrent = winwidth();
$win.on('resize', function () {
  wwCurrent = winwidth();
});

//Sticky Nav
var $is_sticky = $('.is-sticky'), $topbar = $('.topbar'), $topbar_wrap = $('.topbar-wrap');
if ($is_sticky.length > 0) {
  var $navm = $is_sticky.offset();
  $win.scroll(function () {
    var $scroll = $win.scrollTop(), $topbar_height = $topbar.height();
    if ($scroll > $navm.top) {
      if (!$is_sticky.hasClass('has-fixed')) { $is_sticky.addClass('has-fixed'); $topbar_wrap.css('padding-top', $topbar_height); }

    } else {
      if ($is_sticky.hasClass('has-fixed')) { $is_sticky.removeClass('has-fixed'); $topbar_wrap.css('padding-top', 0); }
    }
  });
}

//Data Percent
var $data_percent = $('[data-percent]');
if ($data_percent.length > 0) {
  $data_percent.each(function () {
    var $this = $(this), $this_percent = $this.data('percent');
    $this.css('width', $this_percent + '%');
  });
}

// Active page menu when click
var CurURL = window.location.href, urlSplit = CurURL.split("#");
var $nav_link = $("a");
if ($nav_link.length > 0) {
  $nav_link.each(function () {
    if (CurURL === (this.href) && (urlSplit[1] !== "")) {
      $(this).closest("li").addClass("active").parent().closest("li").addClass("active");
    }
  });
}

// Countdown Clock
var $count_token_clock = $('.countdown-clock');
if ($count_token_clock.length > 0) {
  $count_token_clock.each(function () {
    var $self = $(this), datetime = $self.attr("data-date");
    $self.countdown(datetime).on('update.countdown', function (event) {
      $(this).html(event.strftime('<div><span class="countdown-time countdown-time-first">%D</span><span class="countdown-text">Day</span></div>' + '<div><span class="countdown-time">%H</span><span class="countdown-text">Hour</span></div>' + '<div><span class="countdown-time">%M</span><span class="countdown-text">Min</span></div>' + '<div><span class="countdown-time countdown-time-last">%S</span><span class="countdown-text">Sec</span></div>'));
    });
  });
}

// Select
var $select = $('.select');
if ($select.length > 0) {
  $select.each(function () {
    var $this = $(this);
    $this.select2({
      theme: "flat"
    });
  });
}
var $select_bdr = $('.select-bordered');
if ($select_bdr.length > 0) {
  $select_bdr.each(function () {
    var $this = $(this);
    $this.select2({
      theme: "flat bordered"
    });
  });
}

// Toggle section On click
var _trigger = '.toggle-tigger', _toggle = '.toggle-class';

if ($(_trigger).length > 0) {
  $doc.on('click', _trigger, function (e) {
    var $self = $(this);
    $(_trigger).not($self).removeClass('active');
    $(_toggle).not($self.parent().children()).removeClass('active');
    $self.toggleClass('active').parent().find(_toggle).toggleClass('active');
    e.preventDefault();
  });
}

$doc.on('click', 'body', function (e) {
  var $elm_tig = $(_trigger), $elm_tog = $(_toggle);
  if (!$elm_tog.is(e.target) && $elm_tog.has(e.target).length === 0 &&
    !$elm_tig.is(e.target) && $elm_tig.has(e.target).length === 0) {
    $elm_tog.removeClass('active');
    $elm_tig.removeClass('active');
  }
});

// Mobile Nav
var $toggle_nav = $('.toggle-nav'), $navbar = $('.navbar');
if ($toggle_nav.length > 0) {
  $toggle_nav.on('click', function (e) {
    $toggle_nav.toggleClass('active');
    $navbar.toggleClass('active');
    e.preventDefault();
  });
}
$doc.on('click', 'body', function (e) {
  if (!$toggle_nav.is(e.target) && $toggle_nav.has(e.target).length === 0 &&
    !$navbar.is(e.target) && $navbar.has(e.target).length === 0) {
    $toggle_nav.removeClass('active');
    $navbar.removeClass('active');
  }
});

function activeNav(navbar) {
  if (wwCurrent < 991) {
    navbar.delay(500).addClass('navbar-mobile');
  } else {
    navbar.delay(500).removeClass('navbar-mobile');
  }
}
activeNav($navbar);
$win.on('resize', function () {
  activeNav($navbar);
});


// Tooltip
var $tooltip = $('[data-toggle="tooltip"]');
if ($tooltip.length > 0) {
  $tooltip.tooltip();
}

//Copy Text to Clipboard
function copytoclipboard(triger, action, feedback) {
  var supportCopy = document.queryCommandSupported('copy'), $triger = triger, $action = action, $feedback = feedback;

  $triger.parent().find($action).removeAttr('disabled').select();
  if (supportCopy === true) {

    document.execCommand("copy");
    $feedback.text('Copied to Clipboard').fadeIn().delay(1000).fadeOut();
    $triger.parent().find($action).attr('disabled', 'disabled');
  } else {
    window.prompt("Copy to clipboard: Ctrl+C or Command+C, Enter", text);
  }

}
// Dropdown
var $drop_toggle = $('.drop-toggle');
if ($drop_toggle.length > 0) {
  $drop_toggle.on("click", function (e) {
    if ($win.width() < 991) {
      $(this).parent().children('.navbar-dropdown').slideToggle(400);
      $(this).parent().siblings().children('.navbar-dropdown').slideUp(400);
      $(this).parent().toggleClass('current');
      $(this).parent().siblings().removeClass('current');
      e.preventDefault();
    }
  });
}