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
                        <h1 class="text-3xl">Lista de Permisos</h1>

                        <div>
                            <a class="text-blue-500" href="/index.php">Home</a> / Alumnos
                        </div>
                    </div>

                    <div class="bg-white  divide-y divide-slate-700">
                        <div class="flex justify-between items-center px-2 py-3">
                            <span>Información de Permisos</span>
                        </div>

                        <div class="p-4">
                            <table class="w-full">
                                <thead>
                                    <tr>
                                        <td class="font-bold">#</td>
                                        <td class="font-bold">Email/Usuario</td>
                                        <td class="font-bold">Permisos</td>
                                        <td class="font-bold">Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $row) { ?>
                                        <tr>
                                            <td><?= $row["id"] ?></td>
                                            <td><?= $row["email"] ?></td>
                                            <td><?= $row["description"] ?></td>
                                            <td>
                                                <a href="?action=edit-user-role&user_id=<?= $row["id"] ?>">Editar </a>
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