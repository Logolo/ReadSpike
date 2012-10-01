$(function () {
    //BOF
    
	// add easeInOutCubic easing
	    
	$.extend($.easing,
	{
	    easeInOutCubic: function (x, t, b, c, d) {
	        if ((t/=d/2) < 1) return c/2*t*t*t + b;
	        return c/2*((t-=2)*t*t + 2) + b;
	    },
	});
	
	
	
	// set light
	
	
    $(".lightSwitch").click(function () {

          $("body").addClass("light");
          
          localStorage.setItem("ThemeColour", "Light");
        
        return false;
    });

    $(".darkSwitch").click(function () {

          $("body").removeClass("light");
          
          localStorage.setItem("ThemeColour", "Dark");
        
        return false;
    });


    // Check localstorage for light or dark
    	
    if (localStorage.getItem("ThemeColour") == "Light" || !localStorage.getItem("ThemeColour")) {
    
      $("body").addClass("light");
    
    }else{      
      
      $("body").removeClass("light");
      
    };
    
    
    // reload page after 10 mins
    
     setInterval("location.reload(true)", 600000);




  // scroll to nav
  
  function scrollToDiv(element,navheight){
      var offset = element.offset();
      var offsetTop = offset.top;
      var totalScroll = offsetTop-navheight;
       
      $('body,html').animate({
              scrollTop: totalScroll
      }, 1000, 'easeInOutCubic');
  }
  
  $('.back-to-top').click(function(){
      var el = $(this).attr('href');
      var elWrapped = $(el);
       
      scrollToDiv(elWrapped,40);
      return false;
  });
  
  // show/hide back to top on scroll
  
  jQuery(window).scroll(function(){
   
      if(jQuery(window).scrollTop() > 200){
        // show back to top
        jQuery('.back-to-top').stop().animate({opacity: 1},'fast');
      }
      else{
        // hide back to top
        jQuery('.back-to-top').stop().animate({opacity: 0},'fast');
      }
    });
   
  


    //EOF
});