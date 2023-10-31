<?php require $_SERVER['DOCUMENT_ROOT'] . '/src/templates/head.php'; ?>
<title>Create Student</title>
</head>

<body>
    <div class="grid grid-cols-8 grid-flow-col">

        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/templates/aside-admin.php';  ?>
        <div class="col-star-2 col-span-9 bg-gray-100 w-full h-screen">

            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/templates/nav-admin.php';  ?>
            <main>
                <section class="p-4 ">
                    <div class="flex justify-between mb-4">
                        <h1 class="text-3xl">Dashboard</h1>

                        <div>
                            <a class="text-blue-500" href="">Home</a> / Dashboard
                        </div>
                    </div>
                    <div class="flex flex-col justify-center items-center">

                        <form action="/index.php" method="post" class="flex flex-col gap-3 w-1/2 max-w-xl bg-white p-10 shadow-xl rounded-md">

                            <div class="flex flex-col">
                                <label for="name" class="font-bold">Nombre de la Materia</label>
                                <input type="text" id="name" name="name" class="border-2 p-2 rounded-md">
                            </div>

                            <label for="instructor" class="font-bold">Maestros disponibles para la clase</label>
                            <select name="instructor_id" id="instructor" class="border-2 p-2 rounded-md">
                                <option value="<?= NULL ?>" selected>Sin asignar</option>
                                <?php foreach ($instructors as $row) { ?>
                                    <option value="<?= $row['id']; ?>"><?= $row['fullname']; ?></option>
                                <?php } ?>
                            </select>

                            <input type="hidden" name="action" value="create-clase">

                            <div class="flex justify-end ">
                                <input type="submit" name="create-student" value="Crear" class="bg-blue-500 text-white p-3 rounded-md cursor-pointer">
                            </div>
                        </form>
                    </div>

                </section>

            </main>

        </div>

    </div>

</body>

</html>