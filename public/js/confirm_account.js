$(document).ready(function(){
    $('#account_number').keyup(function() { 
        var accnum = $(this).val();
        if (accnum.length == 10) {
            var bank_code = $('#bank').children("option:selected").val();
            var supplier = $('#supplier').val();
            
            $('#account_confirm').show();
            $('#account_confirm').load("/ajax/getAccountName/" + accnum + "/" + bank_code, function(accname){
                if (accname == 'Error!'){
                    alert ("Error: Invalid Account Number");
                } else {
                    // alert ("Confirm: You are about to pay to " + accname);

                    var r = confirm("Confirm: You are about to pay " + accname);
                    if (r == true) {
                        $('#account_name').val(accname); 

                        // Add Transfer Recipient
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            method: "POST",
                            url: "/ajax/addRecipient",
                            data: { 'name':accname, 'description':supplier, 'account_number':accnum , 'bank_code':bank_code }
                          })
                            .done(function( recipientId ) {
                              if(recipientId != 'Error!'){
                                alert("User has been added to your recipients." );
                                $('#recipient_code').val(recipientId); 
                                $('#others').show();

                                // Enable disabled after confirming recipient
                                $("input[type=submit]").removeAttr("disabled");  
                              } else {
                                alert("Error: We couldn't add " + accname + " as a Fund recipient");
                              }
                                
                              
                            })
                              .fail(function(xhr, textStatus, errorThrown) {
                                alert("Request failed: " + xhr.responseText );
                              });
                    }
                    
                }
            });
            // $('#account_confirm').load('ajax/confirm_account.php', {"acc_num":accnum, "bank_code":bank_code}); // For POST
            
             
        } else {
            $('#account_confirm').hide();
            $('#account_confirm').html('<img src="images/load.gif" alt="loading">');
            $('input[type="submit"]').attr('disabled','disabled');
        }
       
    });

    // $( "#account_number" )
    // .change(function () {
    //     var str = "";
    //     $( "select option:selected" ).each(function() {
    //     str += $( this ).text() + " ";
    //     });
    //     $( "div" ).text( str );
    // })
    // .change();

    // $( "#account_number" ).keyup(function() {
    //     // var text = $( this ).text();
    //     $( "#test" ).val( 'Okay' );
    //   });
});