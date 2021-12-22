function snackbar(mess, type) {
    if (type == 'success') {
        swal(type, mess, 'success');
    } else {
        swal(type, mess, 'error');
    }

}

function copyright() {
    var date = new Date;
    var year = date.getFullYear();
    $('.copyright').html('Copyright © 2015-' + year + ' pyramid trade All Rights Reserved');
}

copyright();

function pic() {
    var a = document.getElementById("customFile");
    var na = new FormData(a);
    // $.ajax({
    // url: "upload.php",
    // type: "POST",
    // data:  new FormData(this),
    // contentType: false,
    // cache: false,
    // processData:false,
    // success: function(data){
    //     if (data == 'ok'){
    // snackbar('upload complete','success');
    // }else{
    // snackbar('upload failed','error');
    // }
    // }           
    // });
}

function sendmess1() {
    var name = jQuery('#name').val();
    var subject = jQuery('#subject').val();
    var message = jQuery('#message').val();
    if (name == '' || subject == '' || message == '') {
        var error = "some fields are empty";
        snackbar(error);
    } else {
        $.ajax({
            url: "parsers/message.php",
            method: "post",
            cache: false,
            dataType: "text",
            data: { send: 1, name: name, subject: subject, message: message },
            success: function(data) {
                if ($.trim(data) == "ok") {
                    var error = "Message sent successfully";
                    snackbar(error);
                    setTimeout(function() { window.location.reload(); }, 1000);
                } else { snackbar(data); }
            }
        });
    }
}

function add_questions(mode, id) {
    var question = jQuery('#created').val();
    var option1 = jQuery('#start').val();
    var option2 = jQuery('#end').val();
    var option3 = jQuery('#hash').val();
    var option4 = jQuery('#type').val();
    var option5 = jQuery('#price').val();
    var option6 = jQuery('#status').val();
    if (question == '' || option1 == '' || option2 == '' || option3 == '' || option4 == '' || option5 == '' || option6 == '') {
        var error = "some fields are empty";
        snackbar(error);
    } else {
        if (mode == 'add') {
            datum = { ask: 1, question: question, option1: option1, option2: option2, option3: option3, option4: option4, option5: option5, option6: option6 };
        } else {
            datum = { update: 1, question: question, option1: option1, option2: option2, option3: option3, option4: option4, option5: option5, option6: option6, tid: id };
        }
        $.ajax({
            url: "process.php",
            method: "post",
            cache: false,
            dataType: "text",
            data: datum,
            success: function(data) {
                if ($.trim(data) == "ok") {
                    var error = "Transactions have been successfully submitted";
                    snackbar(error);
                    setTimeout(function() { window.location.reload(); }, 1000);
                } else { snackbar(data); }
            }
        });
    }
}

function delete_questions(id) {
    $.ajax({
        url: "process.php",
        method: "post",
        cache: false,
        dataType: "text",
        data: { delete: 1, id: id },
        success: function(data) {
            if ($.trim(data) == "ok") {
                var error = "delete success";
                snackbar(error);
                setTimeout(function() { window.location.replace('transactions.php'); }, 1000);
            } else { snackbar(data) }
        }
    });
}

function westernUnion(id) {
    $.ajax({
        url: "login_processor.php",
        method: "post",
        cache: false,
        dataType: "text",
        data: { western: 1, id: id },
        success: function(data) {
            if ($.trim(data) == "ok") {
                var error = "A mail will be sent to you within 24hrs";
                snackbar(error);
            } else { snackbar(data) }
        }
    });
}

function edit_rates() {
    var up = jQuery('#up').val();
    var down = jQuery('#down').val();
    $.ajax({
        url: "process.php",
        method: "post",
        cache: false,
        dataType: "text",
        data: { rates: 1, up: up, down: down },
        success: function(data) {
            if ($.trim(data) == "ok") {
                var error = "edit success";
                snackbar(error);
                //setTimeout(function () {window.location('transactions.php');},1000);
            } else { snackbar(data) }
        }
    });
}

function update_user() {
    var online = jQuery('#online').val();
    var total = jQuery('#total').val();
    var invest = jQuery('#invest').val();
    $.ajax({
        url: "process.php",
        method: "post",
        cache: false,
        dataType: "text",
        data: { update_user: 1, online: online, total: total, invest: invest },
        success: function(data) {
            if ($.trim(data) == "ok") {
                swal("Done!!!", "Updated user values successfully", "success");
                setTimeout(function() { window.location.reload(); }, 2000);
            } else { snackbar(data) }
        }
    });
}

function editRate() {
    var rate = jQuery('#rate').val();
    var address = jQuery('#address').val();
    var phone = jQuery('#phone').val();
    $.ajax({
        url: "process.php",
        method: "post",
        cache: false,
        dataType: "text",
        data: { editRate: 1, rate: rate, address: address, phone: phone },
        success: function(data) {
            if ($.trim(data) == "ok") {
                swal("Done!!!", "company details updated successfully", "success");
                setTimeout(function() { window.location.reload(); }, 2000);
            } else { swal("sorry", data, "error"); }
        }
    });
}

function newUser() {
    var arr = [];
    if (jQuery("input[name = age]:checked").length < 1 ) {
        arr.push("your age");
    }
    if (jQuery("input[name = terms]:checked").length < 1 ) {
        arr.push("our terms");
    }
    if (jQuery("input[name = emailsAgree]:checked").length < 1 ) {
        arr.push("our email terms");
    }
    if (arr.length > 0) {
        var complain = "you must agree to "+arr.join(" and ");
        swal("sorry!!!", complain, "error");
    }else{
        var fname = jQuery('#fname').val();
        var email = jQuery('#email').val();
        var lname = jQuery('#lname').val();
        var ref = jQuery('#ref').val();
        var pass1 = jQuery('#pass1').val();
        var pass2 = jQuery('#pass2').val();
        var gender = jQuery('#gender').val();
        var phone = jQuery('#phone').val();
        var zipcode = jQuery('#zipcode').val();
        var address = jQuery('#address').val();
        var country = jQuery('#country').val();
        var refNum = new Date().getTime();
    $.ajax({
        url: "registerprocessor.php",
        method: "post",
        cache: false,
        beforeSend: function() {
            $('#signupBtn').val('please wait...');
            document.getElementById('signupBtn').disabled = true;
        },
        dataType: "text",
        data: { new: 1, email: email, fname: fname, lname: lname, ref: ref, pass1: pass1, pass2: pass2 ,refNum:refNum, gender:gender, phone:phone, zipcode:zipcode, address:address, country:country},
        success: function(data) {
            $('#signupBtn').val('submit');
            document.getElementById('signupBtn').disabled = false;
            if ($.trim(data) == "ok") {
                var message = "SignUp success...Logging you in";
                snackbar(message, 'success');
                setTimeout(function() { window.location.replace('dashboard.php'); }, 2000);
            } else { snackbar(data, 'error') }
        }
    });
    }
    
}

function sendnewpass(pass, email, data) {
    var message = `<p>Hello there<br>Your new password is ${pass}. Please click the button below to log in. <br> Do not forget to change your password after logging in. </p><p style="text-align:center"><a href="https://uniquefxcapital.com.com/user/" style="padding:10px; background-color:#272c33; border:1px solid #272c33; margin-top:20px; color:white; text-decoration:none">Login</a></p><p style="text-align:right">Regards,<br>The uniquefx capital team</p>`;
    $.ajax({
        url: "../mailer/mail.php",
        method: "post",
        cache: false,
        dataType: "text",
        data: { send: 1, from: 'info@uniquefxcapital.com', to: email, message: message, subject: 'Password Reset' },
        success: function(data) {
            $('.forgotBtn').val('Reset Password');
            snackbar(data.message, 'success');
            setTimeout(function() { window.location.href = 'index.php'; }, 1000);
        }
    });
}

function forgot() {
    var email = jQuery('#email').val();
    $.ajax({
        url: "process.php",
        method: "post",
        cache: false,
        beforeSend: function() { $('.forgotBtn').val('please wait...'); },
        dataType: "json",
        data: { forgot: 1, email: email },
        success: function(data) {
            if (data.success) {
                sendnewpass(data.password, email, data);
            } else { snackbar(data, 'error') }
        }
    });
}

function insertProfit() {
    var hash = jQuery('#hash').val();
    var profit = jQuery('#profit').val();
    var amount_invested = jQuery('#amount_invested').val();
    var id = jQuery('#id').val();
    $.ajax({
        url: "../registerprocessor.php",
        method: "post",
        cache: false,
        dataType: "text",
        data: { profit: 1, hash: hash, profit: profit, amount: amount_invested, id: id },
        success: function(data) {
            if ($.trim(data) == "ok") {
                var error = "profit posted successfully";
                snackbar(error);
                setTimeout(function() { window.location.reload(); }, 1000);
            } else { snackbar(data) }
        }
    });
}

function sig(location) {
    var name = jQuery('#name').val();
    var email = jQuery('#email').val();
    var pass1 = jQuery('#pass1').val();
    var pass2 = jQuery('#pass2').val();
    if (location == "user") {
        var location = "../registerprocessor.php";
    } else {
        var location = "registerprocessor.php";
    }

    if (name == '' || email == '' || pass1 == '' || pass2 == '') {
        var error = "fields cannot be empty";
        snackbar(error);
    } else {
        if (pass1.length < 6 || pass2.length < 6) {
            var error = "passwords must be more that 5 characters";
            snackbar(error);
        } else {
            if (pass1 != pass2) {
                var error = "passwords do not match";
                snackbar(error);
            } else {
                $.ajax({
                    url: location,
                    method: "post",
                    cache: false,
                    dataType: "text",
                    data: { register: 1, name: name, email: email, pass: pass1, pass2: pass2 },
                    success: function(data) {
                        if ($.trim(data) == "ok") {
                            var error = "Registration successful...a mail will be sent for confimation";
                            snackbar(error);
                            setTimeout(function() { sendmail(); }, 3000);
                        } else { snackbar(data) }
                    }
                });
            }
        }
    }
}

function updater() {
    var fname = jQuery('#fnamw').val();
    var lname = jQuery('#lname').val();
    var email = jQuery('#email').val();
    var address = jQuery('#address').val();
    $.ajax({
        url: "update_quantity.php",
        method: "post",
        cache: false,
        dataType: "text",
        data: { update_add: "1", address: address, email: email, fname: fname, lname: lname },
        success: function(data) {
            if ($.trim(data) == "ok") {
                var error = "update complete";
                snackbar(error);
                setTimeout(function() { window.location.reload(); }, 1000);
            } else { snackbar(data) }
        }
    });
}

function payout(id) {
    var details = jQuery('#pay_details').val();
    $.ajax({
        url: "update_quantity.php",
        method: "post",
        cache: false,
        dataType: "text",
        data: { pay: "1", details: details, id: id },
        success: function(data) {
            if ($.trim(data) == "ok") {
                var error = "Order sent successfully, you will receive a reply within 24hrs";
                snackbar(error);
                setTimeout(function() { window.location.reload(); }, 1000);
            } else { snackbar(data) }
        }
    });
}

function loginuser(client) {
    var email = jQuery('#email2').val();
    var pass1 = jQuery('#pass3').val();
    if (client == 'user') {
        var location = "login_processor.php";
        var user = "customer";
    }
    if (client == 'admin') {
        var location = "../user/login_processor.php";
        var user = "admin";
    }
    if (client == 'dashboard') {
        var location = "login_processor.php";
        var user = "customer1";
    }
    $('.notification-bar').css({ 'background-color': 'orange', 'border': '2px solid green', 'padding': '20px', 'margin': '20px', 'width': '100%' }).text('Please Wait...');
    $.ajax({
        url: location,
        method: "post",
        cache: false,
        dataType: "text",
        beforeSend: function(argument) {
            $('.tr1').html('please wait...');
        },
        data: { user: user, email: email, pass: pass1 },
        success: function(data) {
            if ($.trim(data) == "customer" || $.trim(data) == "admin" || $.trim(data) == "customer1") {
                if (data == "customer") {
                    setTimeout(function() { $('.tr1').html('submit'); }, 3000);
                    swal('welcome back...');
                    setTimeout(function() { window.location.replace('dashboard.php'); }, 2000);
                } else if (data == "admin") {
                    setTimeout(function() { $('#greetings').html('Welcome...'); }, 3000);
                    setTimeout(function() { window.location.replace('dashboard.php'); }, 2000);
                } else {
                    snackbar(data);
                    setTimeout(function() { window.location.replace('dashboard.php'); }, 1000);
                }
            } else {
                if (client == 'admin') {
                    $('#greetings').html(data)
                } else {
                    setTimeout(function() { $('.tr1').html('submit'); }, 3000);
                    swal('sorry', data, 'error');
                }
            }
        }
    });
}

function update_details() {
    var fname = jQuery('#fname').val();
    var lname = jQuery('#lname').val();
    var email = jQuery('#email').val();
    var bal = jQuery('#bal').val();
    var id = jQuery('#id').val();
    var profit = jQuery('#profit').val();
    var ref = jQuery('#ref').val();
    $.ajax({
        url: "process.php",
        method: "post",
        cache: false,
        dataType: "text",
        data: { updateDetails: 1, fname: fname, email: email, bal: bal, lname: lname, id: id, profit: profit, ref: ref },
        success: function(data) {
            console.log(data);
            if ($.trim(data) == "ok") {
                var error = "Update success";
                swal("Done!!!", "Account updated successfully", "success");
                setTimeout(function() { window.location.replace('userlist.php'); }, 2000);
            } else { swal("sorry", data, "error"); }
        }
    });
}

function add_dummy() {
    var email = jQuery('#email').val();
    var type = jQuery('#type').val();
    var amount = jQuery('#amount').val();
    var status = jQuery('#status').val();
    $.ajax({
        url: "process.php",
        method: "post",
        cache: false,
        dataType: "text",
        data: { add_dummy: 1, amount: amount, status: status, type: type, email: email },
        success: function(data) {
            if ($.trim(data) == "ok") {
                var error = "Update success";
                swal("alright!!!", "transaction added successfully", "success");
                setTimeout(function() { window.location.reload(); }, 1000);
            } else { swal("sorry", data, "error"); }
        }
    });
}

function changepass() {
    var pass1 = jQuery('#pass1').val();
    var pass2 = jQuery('#pass2').val();
    var oldpass = jQuery('#oldpass').val();
    $.ajax({
        url: "registerprocessor.php",
        method: "post",
        cache: false,
        dataType: "text",
        data: { changepass: 1, pass: pass1, pass2: pass2, oldpass: oldpass },
        success: function(data) {
            if ($.trim(data) == "ok") {
                var error = "Password changed successfully";
                snackbar(error);
                setTimeout(function() { window.location.reload(); }, 1000);
            } else { snackbar(data) }
        }
    });
}

function sendmail() {
    var receiver = jQuery('#receiver').val();
    var sender = jQuery('#sender').val();
    var message = jQuery('#message').val();
    var subject = jQuery('#subject').val();
    if (receiver == '' || sender == '' || message == '' || subject == '') {
        swal('ooops!!!', 'some fields are empty', 'error');
    } else {
        $.ajax({
            url: "../mailer/mail.php",
            method: "post",
            cache: false,
            dataType: "text",
            data: { send: 1, to: receiver, subject: subject, message: message, from: sender },
            success: function(data) {
                if ($.trim(data) == "ok") {
                    var error = "mail sent";
                    swal('awright!!!', error, 'success');
                    setTimeout(function() { window.location.reload(); }, 1000);
                } else { swal('sorry!!!', data, 'error'); }
            }
        });
    }
}

function announce() {
    var message = jQuery('#message').val();
    if (message == '') {
        swal('ooops!!!', 'message cannt be empty', 'error');
    } else {
        $.ajax({
            url: "process.php",
            method: "post",
            cache: false,
            dataType: "text",
            data: { announce: 1,  message: message},
            success: function(data) {
                if ($.trim(data) == "ok") {
                    var error = "Announcement posted";
                    swal('awright!!!', error, 'success');
                    setTimeout(function() { window.location.reload(); }, 1000);
                } else { swal('sorry!!!', data, 'error'); }
            }
        });
    }
}

function deposit() {
    var amount = jQuery('#amount').val();
    var type = jQuery('#type').val();
    var email = jQuery('#email').val();
    if (jQuery.trim(amount) == '' || jQuery.trim(type) == '' || jQuery.trim(email) == '') {
        swal("ooops!!!", "fields cannot be empty", 'error');
    } else {
        jQuery.ajax({
            url: "process.php",
            method: "post",
            cache: false,
            dataType: "text",
            data: { deposit: 1, amount: amount, type: type, email: email },
            success: function(data) {
                if (jQuery.trim(data) == "ok") {
                    swal("Nice!!!", "Details submitted successfully, sending you to payment page...", "success");
                    setTimeout(function() { window.location.replace('invoice.php'); }, 3000);
                } else { swal("ooops!!!", data, 'error'); }
            }
        });
    }
}


function withdraw() {
    var amount = jQuery('#amount').val();
    var type = jQuery('#type').val();
    var btc = jQuery('#btc').val();
    var email = jQuery('#email').val();
    var check = jQuery("#flexCheckChecked").is(':checked') ? 1 : 0;
    if (jQuery.trim(amount) == '' || jQuery.trim(type) == '' || jQuery.trim(email) == '' || jQuery.trim(btc) == '') {
        swal("ooops!!!", "fields cannot be empty", 'error');
    } else {
        jQuery.ajax({
            url: "process.php",
            method: "post",
            cache: false,
            dataType: "text",
            data: { withdraw: 1, amount: amount, type: type, email: email, btc: btc, check:check },
            success: function(data) {
                if (jQuery.trim(data) == "ok") {
                    swal("Nice!!!", "Details submitted successfully, you will be credited within 12-24 hours", "success");
                    //setTimeout(function () {window.location.replace('invoice.php');},3000);
                } else { swal("ooops!!!", data, 'error'); }
            }
        });
    }
}

function withdrawRef(id) {
    var amount = jQuery('#amount').val();
    var type = jQuery('#type').val();
    var btc = 'btc';
    var email = jQuery('#email').val();
    if (jQuery.trim(amount) == '' || jQuery.trim(type) == '' || jQuery.trim(email) == '' || jQuery.trim(btc) == '') {
        swal("ooops!!!", "fields cannot be empty", 'error');
    } else {
        jQuery.ajax({
            url: "process.php",
            method: "post",
            cache: false,
            dataType: "text",
            data: { withdrawRef: 1, amount: amount, type: type, email: email, btc: btc, id:id },
            success: function(data) {
                if (jQuery.trim(data) == "ok") {
                    swal("Nice!!!", "Details submitted successfully, you will be credited within 12-24 hours", "success");
                    //setTimeout(function () {window.location.replace('invoice.php');},3000);
                }else { swal("ooops!!!", data, 'error'); }
            }
        });
    }
}

function confirmwithdraw(user_id, mode, table, where, main_id) {
    var depositAmount = jQuery("#amt").val();
    jQuery.ajax({
        url: "process.php",
        method: "post",
        cache: false,
        dataType: "text",
        data: { confirmwithdraw: 1, mode: mode, user_id: user_id, main_id: main_id, table: table, condition: where, amount: depositAmount },
        success: function(data) {
            if (jQuery.trim(data) == "ok") {
                swal("Done!!!", "you have successfully " + mode + " the transaction", "success");
                setTimeout(function() { window.location.reload(); }, 2000);
            } else { swal("sorry", data, "error"); }
        }
    });
}

function confirmref(user_id, mode, table, where, main_id, id) {
    var depositAmount = $('#bonus'+id).val();
    jQuery.ajax({
        url: "process.php",
        method: "post",
        cache: false,
        dataType: "text",
        data: { confirmref: 1, mode: mode, new_id: user_id, ref_id: main_id, table: table, condition: where, amount: depositAmount, id: id },
        success: function(data) {
            if (jQuery.trim(data) == "ok") {
                swal("Done!!!", "you have successfully " + mode + " the referal", "success");
                setTimeout(function() { window.location.reload(); }, 2000);
            } else { swal("ooops!!!", data, 'error'); }
        }
    });
}

function confirmPaymentRef(id, main_id) {
    var depositAmount = $('#bonus'+id).val();
    jQuery.ajax({
        url: "process.php",
        method: "post",
        cache: false,
        dataType: "text",
        data: { confirmwithdrawref: 1, id: id, main_id: main_id, amount: depositAmount },
        success: function(data) {
            if (jQuery.trim(data) == "ok") {
                swal("Done!!!", "you have successfully payed the referal", "success");
                setTimeout(function() { window.location.reload(); }, 2000);
            } else { swal("ooops!!!", data, 'error'); }
        }
    });
}

function saveDDate(user_id) {
    var date = $('#end' + user_id).val();
    jQuery.ajax({
        url: "process.php",
        method: "post",
        cache: false,
        dataType: "text",
        data: { saveDDate: 1, id_id: user_id, date: date },
        success: function(data) {
            if (jQuery.trim(data) == "ok") {
                swal("Done!!!", "you have successfully saved the expirey date", "success");
                setTimeout(function() { window.location.reload(); }, 2000);
            } else { swal("ooops!!!", data, 'error'); }
        }
    });
}


function invest() {
    var amount = jQuery('#amount').val();
    var type = jQuery('#type').val();
    var email = jQuery('#email').val();
    if (jQuery.trim(amount) == '' || jQuery.trim(type) == '' || jQuery.trim(email) == '') {
        swal("ooops!!!", "fields cannot be empty", 'error');
    } else {
        var amt = parseInt(jQuery.trim(amount));
        if (amt >= 25) {
            if (type == 'VIP') {
                var percent = 15;
            }
            if (type == 'Basic') {
                var percent = 5.5;
            }
            if (type == 'Advanced') {
                var percent = 10.5;
            }
            if (type == 'Special') {
                var percent = 12.5;
            }
            if (type == 'Premium') {
                var percent = 7.5;
            }
            var newType = type;
            var date = new Date();
            var mnth = date.getMonth() + 1;
            var start = date.getDate() + '/' + mnth + '/' + date.getFullYear();
            var num = percent / 100 * parseInt(amount);
            jQuery.ajax({
                url: "process.php",
                method: "post",
                cache: false,
                dataType: "text",
                beforeSend: function(argument) {
                    $('.investBtn').html('please wait...');
                },
                data: { invest: 1, amount: amount, type: type, email: email, profit: num, start: start },
                success: function(data) {
                    if (jQuery.trim(data) == "ok") {
                        $('.investBtn').html('invest');
                        swal("Alright!!!", "You have opted for " + type + " plan, you are being redirected to the payment page...", "success");
                        setTimeout(function() { window.location.replace('invoice.php'); }, 3000);
                    } else { swal("ooops!!!", data, 'error'); }
                }
            });
        } else {
            swal("sorry", "The minimum investment amount is $100", "error");
        }
    }
}


function confirminvest(user_id, mode, table, where, main_id) {
    var profit = jQuery('#profit1').val();
    jQuery.ajax({
        url: "process.php",
        method: "post",
        cache: false,
        dataType: "text",
        data: { confirminvest: 1, mode: mode, user_id: user_id, main_id: main_id, table: table, condition: where, profit: profit },
        success: function(data) {
            if (jQuery.trim(data) == "ok") {
                swal("Done!!!", "you have successfully confirmed an " + mode + " the transaction", "success");
                setTimeout(function() { window.location.reload(); }, 2000);
            } else {
                swal("ooops!!!", data, 'error');
            }
        }
    });
}

function confirmFirstPay(table, where, main_id, amt, mining_id) {
    jQuery.ajax({
        url: "process.php",
        method: "post",
        cache: false,
        dataType: "text",
        data: { confirmFirstPay: 1, table: table, condition: where, main_id: main_id, amt: amt, mining_id: mining_id },
        success: function(data) {
            if (jQuery.trim(data) == "ok") {
                swal("Done!!!", "you have successfully confirmed the transaction", "success");
                setTimeout(function() { window.location.reload(); }, 2000);
            } else {
                swal("ooops!!!", data, 'error');
            }
        }
    });
}

function readmess(id, mode) {
    $.ajax({
        url: "process.php",
        method: "post",
        cache: false,
        dataType: "text",
        data: { read: 1, id: id, mode: mode },
        success: function(data) {
            if ($.trim(data) != "ok") {
                swal(data);
            } else { snackbar(data) }
        }
    });
}

function readmess(id, mode) {
    $.ajax({
        url: "process.php",
        method: "post",
        cache: false,
        dataType: "text",
        data: { read: 1, id: id, mode: mode },
        success: function(data) {
            if ($.trim(data) != "ok") {
                swal(data);
            } else { snackbar(data) }
        }
    });
}

function readconfirm(id) {
    $.ajax({
        url: "process.php",
        method: "post",
        cache: false,
        dataType: "text",
        data: { readconfirm: 1, id: id },
        success: function(data) {
            if ($.trim(data) != "ok") {
                $('#myModal').css({ 'display': 'block' });
                $('#modal_text').html('<img src="../' + data + '">');
            } else { snackbar(data) }
        }
    });
}

function delete_user(id, mode) {
    $.ajax({
        url: "process.php",
        method: "post",
        cache: false,
        dataType: "text",
        data: { mode: mode, id: id },
        success: function(data) {
            if ($.trim(data) != "ok") {
                setTimeout(function() { window.location.reload(); }, 1000);
            } else { setTimeout(function() { window.location.reload(); }, 1000); }
        }
    });
}


jQuery(document).ready(function($) {
    $('.close1').click(function(argument) {
        $('#myModal').css({ 'display': 'none' });
    });
});

jQuery(document).ready(function($) {
    $('.select-trader-btn').click(function(argument) {
        var trader = $("#TraderSelect").val();
        if (trader == "" || trader == "-please select-") {
            swal("sorry", "you have to select a trader", "error");
        }else{
            $.ajax({
                url: "process.php",
                method: "post",
                cache: false,
                dataType: "text",
                data: { select_trader: 1, trader: trader },
                success: function(data) {
                    if ($.trim(data) != "ok") {
                        swal("Alright", "your new trader is "+trader, "success");
                        $('#TraderModal').modal('hide');
                        // setTimeout(function() { window.location.reload(); }, 1000);
                    } else { setTimeout(function() { window.location.reload(); }, 1000); }
                }
            });
        }
        
    });
});