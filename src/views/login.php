<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/dist/output.css">
    <title>Login</title>
</head>

<body>
    <main>

        <?php
        if (isset($message)) {
            echo $message;
        }

        ?>
        <section class="h-screen bg-logo flex flex-col items-center">
            <div class="w-72">
                <img src="/assets/logo.jpg" alt="logo">
            </div>
            <div class="bg-white shadow-md w-96 py-8  px-10 ">
                <h1 class="text-center mb-6">Bienvenido ingresa con tu cuenta</h1>

                <form action="/index.php" method="post" class="flex flex-col gap-3">

                    <div class="border-2 rounded-md ">
                        <input type="email" id="email" name="email" placeholder="Email" class="w-full p-1 ">
                    </div>

                    <div class="border-2 rounded-md">
                        <input type="password" id="password" name="pssword" placeholder="Password" class="w-full p-1 ">
                    </div>

                    <input type="hidden" name="action" value="login">

                    <div class="flex justify-end">
                        <button class="bg-blue-500 text-white rounded-md p-2   ">Ingresar</button>
                    </div>

                </form>
            </div>

        </section>
    </main>
</body>

</html>