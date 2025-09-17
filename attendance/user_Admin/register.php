<?php
    
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Google Docs Register</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    </head>
    <body>
        <main>

            <!-- REGISTER INTERFACE -->
            <div id="register" class="fixed inset-0 bg-white bg-opacity-100 flex flex-col items-center justify-center z-50 p-8">

                <!-- window -->
                <div class="bg-white border rounded-lg shadow-lg p-6 w-[50%] max-h-[80vh] overflow-y-auto">

                    <!-- header -->
                    <h2 class="text-2xl font-bold text-center mb-4">Register</h2>

                    <!-- inputs -->
                    <form id="registerForm" class="w-full mt-10 space-y-10">

                        <!-- input fields -->
                        <div class="space-y-6">

                            <div class="inputField">
                                <label for="username">Username: </label>
                                <input id="formUsername" type="text" name="username" class="inputBox" required>
                            </div>

                            <div class="inputField">
                                <label for="firstName">First Name: </label>
                                <input id="formFirstName" type="text" name="firstName" class="inputBox" required>
                            </div>

                            <div class="inputField">
                                <label for="lastName">Last Name: </label>
                                <input id="formLastName" type="text" name="lastName" class="inputBox" required>
                            </div>

                            <div class="inputField">
                                <label for="password">Password: </label>
                                <input id="formPassword" type="password" name="password" class="inputBox" required>
                            </div>
                            
                            <div class="inputField">
                                <label for="confirmPassword">Confirm Password: </label>
                                <input id="formConfirmPassword" type="password" name="confirmPassword" class="inputBox" required>
                            </div>

                        </div>

                        <!-- buttons -->
                        <div class="space-x-2">
                            <button id="returnToLogin" type="button" onclick="location.href='login.php'" class="px-4 py-2 rounded-full border-2 border-gray-500 text-blue-600 font-semibold hover:bg-blue-200">
                                Back to Login
                            </button>
                            <button id="registerBtn" class="px-6 py-2 bg-blue-500 rounded-full text-lg text-white font-semibold hover:bg-blue-700">
                                Register
                            </button>
                        </div>

                    </form>
                    
                </div>

            </div>
            <!-- /REGISTER INTERFACE -->

        </main>


        <script src="myScripts.js"></script>
    </body>
</html>