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
	
	// submit ajax form
  
    $(".feedback-form").submit(function(event) {

    /* stop form from submitting normally */
    event.preventDefault(); 
        
    /* get some values from elements on the page: */
    var $form = $( this ),
        name = $form.find( 'input[name="name"]' ).val(),
        email = $form.find( 'input[name="email"]' ).val(),
        message = $form.find( 'input[name="message"]' ).val(),
        url = $form.attr( 'action' );

    /* Send the data using post and put the results in a div */
    $.post( url, { name: name, email: email, message: message },
      function( $form  ) {
          var content = $( name ).find( '.contact-form' );	      
          $( ".result" ).fadeIn();
          $( ".result" ).empty().append( "Thanks " + name  );
          $(".contact-form").fadeOut();
      }
    );
  });  
  
  
    // show/hide contact form
  
    $(".show-contact-form").on("click", function(){        
        $(".contact-form").fadeIn('fast');
        return false;
    }); 
    
    $(".close-contact-form").on("click", function(){        
        $(".contact-form").fadeOut('fast');
        return false;
    });    
    	
    	// close with esc
    	
    	$(document).keyup(function(e) {
        if (e.keyCode == 27) { $(".contact-form").fadeOut('fast');}   // esc
      });
         
          	

  // detect iPad

	var isiPad = navigator.userAgent.match(/iPad/i) != null;

  // open links in same window on mobile, blank on desktop/ipad
  
  if($(window).width() < 480 || isiPad){
     $(".links-list a[href^='http://']").attr("target","_self");
	 }else{
  	 $(".links-list a[href^='http://']").attr("target","_blank");
	 }

	 
	 // image preview
  
    $(".show-image").on("click", function(){
        var imgUrl = $(this).attr('href');
        var imgTrigger = $(this);
        $(imgTrigger).siblings(".full-image").hide().html("<a href='" + imgUrl + "' title='View full size' target='_blank'><img src='" + imgUrl + "' alt='' /></a>").fadeIn();
        
        $(imgTrigger).hide();
        $(imgTrigger).siblings(".hide-image").show();
        $(imgTrigger).siblings(".story-title").addClass("open-story");
        return false;
    });
  
  
    $(".hide-image").on("click", function(){
        var hideTrigger = $(this); 
        $(hideTrigger).hide();
        $(hideTrigger).siblings(".show-image").show().siblings(".full-image").slideUp('fast');
        $(hideTrigger).siblings(".story-title").removeClass("open-story");
        return false;
    });    	
    	
    	
    	// load thumbnail on hover 
    	
    	$(".show-image").on("hover", function(){      	
      	
      	var thumbDiv = $(this).next(".thumbnail");      	
      	var thumbURL =  $(thumbDiv).attr("data-thumbnail");      	
      	//console.log (thumbURL);       	
      	$(thumbDiv).css({backgroundImage : 'url('+thumbURL+')'});
      	 
    	});
    	
    	
    	
	  
	 // bbc/google news tabs
	  
		$('.tab-header.bbc-title').addClass('active').addClass("news-title-prefix");
		
  		$('.tab-header').on("click", function(){
		
  		var tabID = $(this).attr('data-source'); // Get the value of clicked a's href attribute
  		
  		var tabID = "."+tabID;
  		
  		$('.tab-content').hide(); // Hide all tab
  		
  		$(tabID).fadeIn(); // Show aimed tab
  		
  		$('.tab-header').removeClass('active news-title-prefix'); // Remove 'active' class from all nav item
  		
  		$(this).addClass('active').addClass("news-title-prefix");; // Add 'active' class to clicked nav item
  		
  		return false; 
  		
		});
		
		
		$(".tab-header").on("dblclick", function(){        
        
        //alert("test")
        window.location = $(this).attr("href");
    }); 
          	
	 
	// set light
	
	
    $(".lightSwitch").on("click", function(){

          $("body").addClass("light");
          
          localStorage.setItem("ThemeColour", "Light");
        
        return false;
    });

    $(".darkSwitch").on("click", function(){

          $("body").removeClass("light");
          
          localStorage.setItem("ThemeColour", "Dark");
        
        return false;
    });
    

    // Check localstorage for light or dark
    	
    if (localStorage.getItem("ThemeColour") == "Light") {
    
      $("body").addClass("light");
    
    }else{      
      
      $("body").removeClass("light");
      
    };
    
    
    
    // show more
    $(".show-more").on("click", function(){

        $(this).prev(".links-list").children("li:nth-child(n+10)").fadeToggle();      
          
        return false;
        
    }).toggle( //toggle text
      function(){
        $(this).text("Show less");
      },
      function(){
        $(this).text("Show more");
      });;
            
    
    
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
  
  $('.back-to-top').on("click", function(){
      var el = $(this).attr('href');
      var elWrapped = $(el);
       
      scrollToDiv(elWrapped,40);
      return false;
  });
  
  // show/hide back to top on scroll
  
  $(window).scroll(function(){
   
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