<?php require $_SERVER['DOCUMENT_ROOT'] . '/src/templates/head.php'; ?>
<title>Dashboard</title>
</head>


<body>
    <div class="grid grid-cols-8 grid-flow-col">

        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/templates/aside-admin.php';  ?>
        <div class="col-star-2 col-span-9 bg-gray-100 w-full h-screen">

            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/templates/nav-admin.php';  ?>
            <main>
                <section class="p-4 ">
                    <div class="flex justify-between mb-4">
                        <h1 class="text-3xl">Lista de alumnos</h1>

                        <div>
                            <a class="text-blue-500" href="/index.php">Home</a> / Alumnos
                        </div>
                    </div>

                    <div class="bg-white  divide-y divide-slate-700">
                        <div class="flex justify-between items-center px-2 py-3">
                            <span>Información de Alumnos</span>
                            <a href="/index.php?action=create-student-view" class="bg-blue-500 text-white p-2 rounded-md cursor-pointer">Agregar Alumno</a>
                        </div>

                        <div class="p-3">

                            <table class="w-full ">
                                <thead>
                                    <tr>
                                        <td class="font-bold">#</td>
                                        <td class="font-bold">DNI</td>
                                        <td class="font-bold">Nombre</td>
                                        <td class="font-bold">Correo</td>
                                        <td class="font-bold">Direccion</td>
                                        <td class="font-bold">Fec. de Nacimiento</td>
                                        <td class="font-bold">Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $row) { ?>
                                        <tr>
                                            <td><?= $row["student_id"] ?></td>
                                            <td><?= $row["dni"] ?></td>
                                            <td><?= $row["name"] ?></td>
                                            <td><?= $row["email"] ?></td>
                                            <td><?= $row["address"] ?></td>
                                            <td><?= $row["birthday"] ?></td>

                                            <td>
                                                <a href="?action=edit-student-view&user_id=<?= $row["id"] ?>">Editar </a>

                                                <form action="/index.php" method="post" class="inline">
                                                    <input type="text" hidden name="user_id" value="<?= $row["id"] ?>">
                                                    <input type="hidden" name="action" value="delete-student">
                                                    <button type="submit">Delete</button>
                                                </form>
                                            </td>
                                        </tr>

                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </section>

            </main>

        </div>

    </div>

</body>

</html>