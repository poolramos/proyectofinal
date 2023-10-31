<?php require $_SERVER['DOCUMENT_ROOT'] . '/src/templates/head.php'; ?>
<title>Editar Permisos</title>
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

                            <input type="hidden" name="user_id" value="<?= $user["id"] ?>">

                            <div class="flex flex-col">
                                <label for="email">Email del usuario</label>
                                <input disabled type="text" id="email" name="email" class="border-2" value="<?= $user["email"] ?>">
                            </div>

                            <select name="role" id="role">
                                <?php
                                foreach ($roles as $role) {
                                    if ($role["id"] == $user["role_id"]) {
                                        echo "<option value='$role[id]' selected>$role[description]</option>";
                                    } else {
                                        echo "<option value='$role[id]'>$role[description]</option>";
                                    }
                                }
                                ?>
                            </select>

                            <input type="hidden" name="action" value="update-rol">

                            <div class="flex justify-end ">
                                <input type="submit" name="create-student" value="Guardar Cambios" class="bg-blue-500 text-white p-3 rounded-md cursor-pointer">
                            </div>
                        </form>
                    </div>

                </section>

            </main>

        </div>

    </div>

</body>

</html>