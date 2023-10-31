<aside class="bg-slate-800 text-white col-star-1 col-span-1 h-screen shadow-xl divide-y divide-slate-700">

    <div class="flex items-center gap-2 mr-3 my-2 px-4">
        <div class="w-11">
            <img src="/assets/logo.jpg" alt="">
        </div>

        <span>Universidad</span>
    </div>

    <div class="py-6  flex flex-col px-4">
        <span>Maestro</span>
        <span><?= $_SESSION["userData"]["firstname"] . ' ' . $_SESSION["userData"]["lastname"]?></span>
    </div>

    <div class="">
        <p class="text-center text-[11px] my-4">MENU MAESTROS</p>

        <?php require $_SERVER['DOCUMENT_ROOT'] . '/src/views/instructor/menu-instructor.php'; ?>


    </div>
</aside>
<div class="col-star-2 col-span-9 bg-gray-100 w-full h-screen">

    <nav class="flex justify-between items-center p-4 mb-1 bg-white">
        <div>
            <span>###</span>
            <span>Home</span>
        </div>

        <div>
            <span>Profesor | </span>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/templates/logout-button.php'; ?>
        </div>

    </nav>