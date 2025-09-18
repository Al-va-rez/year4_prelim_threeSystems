<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
</head>
<body>
    <div class="flex flex-col justify-center items-center mx-auto gap-4 mt-24 py-24">
        <div class="portal" onclick="location.href='user_Student/login.php'">Student</div>
        <div class="portal" onclick="location.href='user_Admin/login.php'">Admin</div>
    </div>

    <script>
        $('.portal').addClass('border border-black rounded w-1/2 p-6 font-bold hover:bg-red-200 hover:cursor-pointer');
    </script>
</body>
</html>