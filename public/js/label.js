
$(document).ready(function () {
	$('.star').on('click', function () {
      $(this).toggleClass('star-checked');});

    $('.ckbox label').on('click', function () {
      $(this).parents('tr').toggleClass('selected');});

    $('.ckbox label').on('click', function () {
        var id = $(this).attr('id');
        id = id.split('-');
        $.ajax({
            type: "POST",
            url: "label/selected",
            data: 
                "id=" + id[1],
            success : function(data){            
                if(data){
                    console.log(data);}
                else {
                    console.log("false");}}});});

    $('.glyphicon-star').on('click', function () {
        var id = $(this).attr('id');
        id = id.split('-');
        $.ajax({
            type: "POST",
            url: "label/star",
            data: 
                "id=" + id[1],
            success : function(data){            
                if(data){
                    console.log(data);}
                else {
                    console.log("false");}}});});

    $('.btn-filter').on('click', function () {
      var $target = $(this).data('target');
      if ($target != 'all') {
        $('.table tr').css('display', 'none');
        $('.table tr[data-status*="' + $target + '"]').fadeIn('slow');
        console.log($target);        
      } else {
        $('.table tr').css('display', 'none').fadeIn('slow');
      }
    });

 });


