<?php require $_SERVER['DOCUMENT_ROOT'] . '/src/templates/head.php'; ?>
<title>Edit Student</title>
</head>

<body>
    <div class="grid grid-cols-8 grid-flow-col">

        <?php require $_SERVER['DOCUMENT_ROOT'] . '/src/views/student/nav-aside.php'; ?>
        <main>
            <section class="p-4 ">
                <div class="flex justify-between mb-4">
                    <h1 class="text-3xl">Dashboard</h1>

                    <div>
                        <a class="text-blue-500" href="">Home</a> / Dashboard
                    </div>
                </div>
                <div class="flex flex-col justify-center items-center">

                    <?php

                    if (isset($message)) {
                        echo $message;
                    }

                    ?>
                    <form action="/index.php" method="post" class="flex flex-col gap-3 w-1/2 max-w-xl bg-white p-10 shadow-xl rounded-md">

                        <input type="hidden" name="id" value="<?= $student["id"] ?>">

                        <div class="flex flex-col">
                            <label for="dni">Matricula</label>
                            <input type="text" disabled id="dni" name="dni" value="<?= $student["dni"] ?>" class="border-2">
                        </div>

                        <div class="flex flex-col">

                            <label for="firstname">Nombres</label>
                            <input type="text" id="firstname" name="firstname" class="border-2" value="<?= $student["firstname"] ?>">
                        </div>

                        <div class="flex flex-col">

                            <label for="lastname">Apellidos</label>
                            <input type="text" id="lastname" name="lastname" class="border-2" value="<?= $student["lastname"] ?>">
                        </div>

                        <div class="flex flex-col">

                            <label for="email">Correo</label>
                            <input type="email" disabled id="email" name="email" class="border-2" value="<?= $student["email"] ?>">
                        </div>


                        <div class="flex flex-col">

                            <label for="address">Dirección</label>
                            <input type="text" id="address" name="address" class="border-2" value="<?= $student["address"] ?>">
                        </div>


                        <div class="flex flex-col">

                            <label for="birthday">Fech. de Nacimiento</label>
                            <input type="date" id="birthday" name="birthday" class="border-2" value="<?= $student["birthday"] ?>">
                        </div>


                        <input type="hidden" name="action" value="edit-student">

                        <div class="flex justify-end ">
                            <input type="submit" name="edit-student" value="Editar" class="bg-blue-500 text-white p-3 rounded-md cursor-pointer">
                        </div>
                    </form>
                </div>

            </section>

        </main>

    </div>

    </div>

</body>

</html>