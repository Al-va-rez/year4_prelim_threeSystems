<?php

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Googl Docs Login</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    </head>
    <body>
        <main>

            <!-- LOGIN INTERFACE -->
            <div id="login" class="fixed inset-0 bg-gray-200 bg-opacity-100 flex flex-col items-center justify-center z-50 p-8">

                <!-- window -->
                <div class="bg-white border rounded-lg shadow-lg p-6 w-[40%] max-h-[80vh]">

                    <!-- header -->
                    <h2 class="text-3xl font-bold text-center">Login as Student</h2>

                    <!-- inputs -->
                    <form id="loginForm" class="mt-10 space-y-10">

                        <!-- input fields -->
                        <div class="space-y-4">
                            <div class="inputField">
                                <label for="username">Username: </label>
                                <input id="formUsername" type="text" name="username" class="inputBox" required>
                            </div>
                            <div class="inputField">
                                <label for="password">Password: </label>
                                <input id="formPassword" type="password" name="password" class="inputBox" required>
                            </div>
                        </div>
                        
                        <!-- buttons -->
                        <div class="space-x-2">
                            <button id="registerBtn" type="button" onclick="location.href='register.php'" class="px-4 py-2 rounded-full border-2 border-gray-500 text-blue-600 font-semibold hover:bg-blue-200">
                                Register
                            </button>
                            <button id="loginBtn" type="submit" class="px-6 py-2 bg-blue-500 rounded-full text-lg text-white font-semibold hover:bg-blue-700">
                                Login
                            </button>
                        </div>

                    </form>
                    
                </div>

            </div>
            <!-- /LOGIN INTERFACE -->

        </main>


        <script src="myScripts.js"></script>
    </body>
</html>