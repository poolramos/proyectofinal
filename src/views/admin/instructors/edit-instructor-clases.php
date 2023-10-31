<?php require $_SERVER['DOCUMENT_ROOT'] . '/src/templates/head.php'; ?>
<title>Edit Student</title>
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

                        <h2 class="text-2xl mb-4">Editar Clases</h2>

                        <form action="/index.php" method="post" class="flex flex-col gap-3 w-1/2 max-w-xl bg-white p-10 shadow-xl rounded-md">

                            <input type="hidden" name="instructor_id" value="<?= $instructorId ?>">

                            <div>
                                <?php foreach ($clases as $row) {  ?>
                                    <div>
                                        <label for="clases"><?= $row["clase_name"] ?></label>
                                        <input type="checkbox" name="clases[]" value="<?= $row["clase_id"] ?>" <?= $instructorId == $row["instructor_id"] ? "checked" : "" ?>>
                                    </div>
                                <?php } ?>
                            </div>

                            <input type="hidden" name="action" value="edit-instructor-clases">

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