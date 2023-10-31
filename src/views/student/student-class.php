<?php require $_SERVER['DOCUMENT_ROOT'] . '/src/templates/head.php'; ?>
<title>Clases - Alumno</title>
</head>

<body>
    <div class="grid grid-cols-8 grid-flow-col">

        <?php require $_SERVER['DOCUMENT_ROOT'] . '/src/views/student/nav-aside.php'; ?>
        <main>
            <section class="p-4 ">
                <div class="flex justify-between mb-4">
                    <h1 class="text-3xl">Lista de alumnos</h1>

                    <div>
                        <a class="text-blue-500" href="/index.php">Home</a> / Alumnos
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-2">

                    <div class="bg-white  divide-y divide-slate-700 p-3 col-start-1 col-span-8 ">
                        <div class="flex justify-between items-center px-2 py-3">
                            <span>Información de Alumnos</span>
                        </div>


                        <table class="w-full ">
                            <thead>
                                <tr>
                                    <td class="font-bold">#</td>
                                    <td class="font-bold">Clase</td>
                                    <td class="font-bold">Darse de baja</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($studentClasses as $row) { ?>
                                    <tr>
                                        <td><?= $row["class_id"] ?></td>
                                        <td><?= $row["class_name"] ?></td>
                                        <td class="text-blue-500"><a href="/index.php?action=delete-student-class&class_id=<?= $row["class_id"] ?>&student_id=<?= $row["student_id"] ?>">Eliminar Clase</a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-start-9 col-span-12 w-full bg-white p-4">
                        <div class="divide-slate-700 ">
                            <h2>Material para inscribir</h2>
                        </div>
                        <span>Selecciona las clases:</span>
                        <div>
                            <?php foreach ($classesNotRegistered as $row) { ?>
                                <div class="flex justify-between items-center">
                                    <span><?= $row["class_name"] ?></span>
                                    <a class="text-blue-500" href="/index.php?action=add-student-class&class_id=<?= $row["class_id"] ?>&student_id=<?= $id ?>">Inscribir</a>
                                </div>

                            <?php } ?>
                        </div>
                    </div>
                </div>

            </section>

        </main>

    </div>

    </div>

</body>

</html>