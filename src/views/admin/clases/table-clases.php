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
                        <h1 class="text-3xl">Lista de Clases</h1>

                        <div>
                            <a class="text-blue-500" href="/index.php">Home</a> / Clasesz
                        </div>
                    </div>

                    <div class="bg-white  divide-y divide-slate-700">
                        <div class="flex justify-between items-center px-2 py-3">
                            <span>Información de Clases</span>
                            <a href="/index.php?action=create-clase-view" class="bg-blue-500 text-white p-2 rounded-md cursor-pointer">Agregar Clase</a>
                        </div>

                        <div class="p-3">

                            <table class="w-full">
                                <thead>
                                    <tr>
                                        <td class="font-bold">#</td>
                                        <td class="font-bold">Clase</td>
                                        <td class="font-bold">Maestro</td>
                                        <td class="font-bold">Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($clases as $row) { ?>
                                        <tr>
                                            <td><?= $row["id"] ?></td>
                                            <td><?= $row["name"] ?></td>
                                            <td><?= $row["maestro"] ?></td>
                                            <td>
                                                <a href="?action=edit-clase-view&clase_id=<?= $row["id"] ?>">Editar </a>

                                                <form action="/index.php" method="post" class="inline">
                                                    <input type="text" hidden name="clase_id" value="<?= $row["id"] ?>">
                                                    <input type="hidden" name="action" value="delete-clase">
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