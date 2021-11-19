(function( $ ) {
  $(function() {
  	console.log($('#timeFrom'));
  	console.log($('#timeTo'));
    $('#timeFrom').mask('00:00');
    $('#timeTo').mask('00:00');
   

    $('pre').each(function(i, e) {hljs.highlightBlock(e)});
  });
})(jQuery);


// selectStudents.addEventListener('change', e => {
// 	console.log(e.target.value)
// 	// const urlParams = new URLSearchParams(window.location.search);
// 	// urlParams.set('student', 'date');
	
// 	// window.location.search = urlParams;
// })
