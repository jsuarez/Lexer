jQuery.fn.fadeToggle = function(speed, easing, callback) {
  return this.animate({opacity: 'toggle'}, speed, easing, callback);  
};

$(document).ready(function() {
  $('#fade').click(function() {
    $(this).next().fadeToggle('slow');
  });
  
});


jQuery.fn.slideFadeToggle = function(speed, easing, callback) {
  return this.animate({opacity: 'toggle', height: 'toggle'}, speed, easing, callback);  
};

$(document).ready(function() {
  $('#slide-fade').click(function() {
    $(this).next().slideFadeToggle('slow', function() {
      var $this = $(this);
      if ($this.is(':visible')) {
        $this.text('Successfully opened.');
      } else {
        $this.text('Sucessfully closed.');
      }
    });
  });
  
});

jQuery.fn.blindToggle = function(speed, easing, callback) {
  var h = this.height() + parseInt(this.css('paddingTop')) + parseInt(this.css('paddingBottom'));
  return this.animate({marginTop: parseInt(this.css('marginTop')) < 0 ? 0 : -h}, speed, easing, callback);  
};

$(document).ready(function() {
  var $box = $('#box')
    .wrap('<div id="box-outer"></div>');
  $('#blind').click(function() {
    $box.blindToggle('slow');  
  });    
});