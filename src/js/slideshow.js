(function ($, window, undefined) {
    $(function(){
        var counter = 0, // to keep track of current slide
            $items = $('.diy-slideshow figure'), 
            numItems = $items.length; // total number of slides
        
        // this function is what cycles the slides, showing the next or previous slide and hiding all the others
        var showCurrent = function(){
            var itemToShow = Math.abs(counter%numItems);
           
            $items.removeClass('show'); // remove .show from whichever element currently has it
            $items.eq(itemToShow).addClass('show');    
        };
        
        // add click events to prev & next buttons 
        $('.next').on('click', function(){
            counter++;
            showCurrent(); 
        });
        $('.prev').on('click', function(){
            counter--;
            showCurrent(); 
        });
        
       
        if('ontouchstart' in window){
            $('.diy-slideshow').swipe({
                swipeLeft:function() {
                    counter++;
                    showCurrent(); 
                },
                swipeRight:function() {
                    counter--;
                    showCurrent(); 
                }
            });
        }
    });
})(jQuery, window);
(function(document){
  
    var counter = 0, // to keep track of current slide
    $items = document.querySelectorAll('.diy-slideshow figure'), 
    numItems = $items.length; // total number of slides

    // this function is what cycles the slides, showing the next or previous slide and hiding all the others
    var showCurrent = function(){
        var itemToShow = Math.abs(counter%numItems);
  
        
        [].forEach.call( $items, function(el){
            el.classList.remove('show');
        });
  
        // add .show to the one item that's supposed to have it
        $items[itemToShow].classList.add('show');    
    };

// add click events to prev & next buttons 
    document.querySelector('.next').addEventListener('click', function() {
        counter++;
        showCurrent();
    }, false);

    document.querySelector('.prev').addEventListener('click', function() {
        counter--;
        showCurrent();
    }, false);
  
})(document);  