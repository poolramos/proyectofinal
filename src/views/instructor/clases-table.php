<?php require $_SERVER['DOCUMENT_ROOT'] . '/src/templates/head.php'; ?>
<title>Dashboard - Maestro</title>
</head>

<body>
    <div class="grid grid-cols-8 grid-flow-col">

        <?php require $_SERVER['DOCUMENT_ROOT'] . '/src/views/instructor/nav-aside.php'; ?>
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
                    </div>

                    <div class="p-3">

                        <table class="w-full ">
                            <thead>
                                <tr>
                                    <td class="font-bold">#</td>
                                    <td class="font-bold">Clase</td>
                                    <td class="font-bold">Acciones</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($clases as $row) { ?>
                                    <tr>
                                        <td><?= $row["class_id"] ?></td>
                                        <td><?= $row["class_name"] ?></td>
                                        <td class="text-blue-500"><a href="/index.php?action=show-student-class&class_id=<?= $row["class_id"] ?>&class_name=<?= $row["class_name"] ?>">Ver estudiantes de esta clase</a></td>
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