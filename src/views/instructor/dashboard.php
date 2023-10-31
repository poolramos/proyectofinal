<?php require $_SERVER['DOCUMENT_ROOT'] . '/src/templates/head.php'; ?>
<title>Dashboard - Maestro</title>
</head>

<body>
    <div class="grid grid-cols-8 grid-flow-col">

        <?php require $_SERVER['DOCUMENT_ROOT'] . '/src/views/instructor/nav-aside.php'; ?>
            <main>
                <section class="p-4 ">
                    <div class="flex justify-between mb-4">
                        <h1 class="text-3xl">Dashboard</h1>

                        <div>
                            <a class="text-blue-500" href="">Home</a> / Dashboard
                        </div>
                    </div>

                    <div class="bg-white w-1/2 p-5 shadow-lg">
                        <h2>Bienvenido</h2>
                        <p>Selecciona la accion que quieras realizar en las pestañas del menu de la izquierda</p>
                    </div>

                </section>

            </main>

        </div>

    </div>

</body>

</html>