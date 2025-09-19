// input field styles
    $('.inputBox').addClass('border border-gray-500 rounded-md focus:cursor-none focus:outline-blue-500');

    $('.inputField').addClass('flex flex-col w-full text-xl');
// input field styles


// form submission handlers
    $('#registerForm').on('submit',
        function(event) {
            event.preventDefault();

            var formData = {
                username: $('#formUsername').val(),
                firstName: $('#formFirstName').val(),
                lastName: $('#formLastName').val(),
                password: $('#formPassword').val(),
                confirmPassword: $('#formConfirmPassword').val(),
                registerAdminReq: 1
            };


            $.ajax(
                {
                    type: "POST",
                    url: "../core/handleForms.php",
                    data: formData,
                    success: function(data) {
                        data = data.trim();
                        switch (data) {
                            case 'Success':
                                alert("Registration successful! Redirecting to login page...");
                                setTimeout(function() {
                                    window.location.href = "login.php";
                                }, 500);
                                break;
                            
                            case 'Weak password':
                                alert(data);
                                break;
                            
                            case 'Passwords not the same':
                                alert(data);
                                break;
                            
                            case 'User already registered':
                                alert(data);
                                break;

                            case 'Password already in use':
                                alert(data);
                                break;
                        
                            default:
                                console.log('something went wrong');
                                console.log(data);
                                break;
                        }
                        
                    }
                }
            )
        }
    )


    $('#loginForm').on('submit',
        function(event) {
            event.preventDefault();

            var formData = {
                username: $('#formUsername').val(),
                password: $('#formPassword').val(),
                loginAdminReq: 1
            };


            $.ajax(
                {
                    type: "POST",
                    url: "../core/handleForms.php",
                    data: formData,
                    success: function(data) {
                        data = data.trim();
                        switch (data) {
                            case 'Success':
                                window.location.href = "index.php";
                                break;
                            
                            case 'Incorrect Username/Password':
                                alert(data);
                                break;
                            
                            case 'User not registered':
                                alert(data);
                                break;
                        
                            default:
                                console.log('something went wrong');
                                console.log(data);
                                break;
                        }
                        
                    }
                }
            )
        }
    )
// form submission handlers