$(function() {
    
    $('#login-form-link').click(function(e) {
		$("#login-form").delay(100).fadeIn(100);
 		$("#register-form").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
	$('#register-form-link').click(function(e) {
		$("#register-form").delay(100).fadeIn(100);
 		$("#login-form").fadeOut(100);
		$('#login-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});

    // on click of submit button
    $("#login-submit").click(function(ev) {
        ev.preventDefault();
        var form = $("#login-form");
        $.ajax({
            type: "POST",
            url: 'controller/user.php',
            dataType :'json',
            data: form.serialize(),
            beforeSend:function(){
                $('.username').next().addClass('d-none').text('')
                $('.password').next().addClass('d-none').text('')
                $('.invalid-credentials').addClass('d-none').text('')
            },
            success: function(data) {
                if (data.success){
                    location.href = 'dashboard.php';
                } else if (data.error){
                    $.each(data.validationError, function( index, value ) {
                        $('.'+index).next().removeClass('d-none').text(value)
                    });
                } else {
                    $('.invalid-credentials').removeClass('d-none').text(data.message)
                }
            },
            error: function(data) {
                swal({
                    title: "Error!",
                    text: 'Something went Wrong!',
                    icon: "error",
                  });
            }
        });
    });
    // on click of submit button
    $("#register-submit").click(function(ev) {
        ev.preventDefault();
        var form = $("#register-form")[0];
         // Create an FormData object
          var data = new FormData(form);
        $.ajax({
            type: "POST",
            url: 'controller/user.php',
            cache: false,
            contentType: false,
            processData: false,
            dataType :'json',
            data: data,
            beforeSend:function(){
                $('.username').next().addClass('d-none').text('')
                $('.password').next().addClass('d-none').text('')
                $('.confirm-password').next().addClass('d-none').text('')
                $('.last_name').next().addClass('d-none').text('')
                $('.first_name').next().addClass('d-none').text('')
                $('.invalid-credentials').addClass('d-none').text('')
            },
            success: function(data) {
                  if (data.success){
                    swal({
                        title: "Success!",
                        text: data.message,
                        icon: "success",
                    }).then((value) => {
                        location.href = 'dashboard.php';
                    });
                  } else if (data.error){
                    $.each(data.validationError, function( index, value ) {
                        $('.'+index).next().removeClass('d-none').text(value)
                    });
                } else {
                    $('.invalid-credentials').removeClass('d-none').text(data.message)
                }
            },
            error: function(data) {
                swal({
                    title: "Error!",
                    text: 'Something went Wrong!',
                    icon: "error",
                  });
            }
        });
    });
    $('#logout-user').click(function(){
        swal({
            title: "Are you sure?",
            text: "You want to logout?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "POST",
                url: "controller/user.php",
                data: {action:'logout'},
                dataType: "json",
                success: function (data) {
                    if (data.success){
                        location.href = 'dashboard.php';
                    } else {
                        swal({
                            title: "Error!",
                            text: data.message,
                            icon: "error",
                        })
                    }
                }
            });
        }
        });
    })

        // on click of submit button
        $("#update-submit").click(function(ev) {
            ev.preventDefault();
            var form = $("#update-form")[0];
            var data = new FormData(form);

            $.ajax({
                type: "POST",
                url: 'controller/user.php',
                cache: false,
                contentType: false,
                processData: false,
                dataType :'json',
                data: data,
                beforeSend:function(){
                    $('.username').next().addClass('d-none').text('')
                    $('.password').next().addClass('d-none').text('')
                    $('.confirm-password').next().addClass('d-none').text('')
                    $('.last_name').next().addClass('d-none').text('')
                    $('.first_name').next().addClass('d-none').text('')
                    $('.invalid-credentials').addClass('d-none').text('')
                },
                success: function(data) {
                      if (data.success){
                        swal({
                            title: "Success!",
                            text: data.message,
                            icon: "success",
                        }).then((value) => {
                            location.href = 'dashboard.php';
                        });
                      } else if (data.warning){
                        swal({
                            title: "Info!",
                            text: data.message,
                            icon: "info",
                        });
                      } else if (data.error){
                        $.each(data.validationError, function( index, value ) {
                            $('.'+index).next().removeClass('d-none').text(value)
                        });
                    } else {
                        $('.invalid-credentials').removeClass('d-none').text(data.message)
                    }
                },
                error: function(data) {
                    swal({
                        title: "Error!",
                        text: 'Something went Wrong!',
                        icon: "error",
                      });
                }
            });
        });
});
