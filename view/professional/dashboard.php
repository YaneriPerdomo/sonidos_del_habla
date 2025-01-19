<?php
include '../../php/validation/authorized-user.php';
?>

<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicia sesion | Sonidos de habla</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../../css/components/body.css">
    <link rel="stylesheet" href="../../css/components/footer.css">
    <link rel="stylesheet" href="../../css/components/button.css">
    <link rel="stylesheet" href="../../css/components/header.css">
    <link rel="stylesheet" href="../../css/components/auxiliary.css">
    <link rel="stylesheet" href="../../css/components/modal-window.css">
    <link rel="stylesheet" href="../../css/admin/header.css">
    <link rel="stylesheet" href="../../css/admin/dashboard.css">

    <style>
        .row>div>div {
            padding: 1rem;
            background: white;
            border-radius: 6px;
        }
    </style>
</head>

<body>

    <?php include '../include/professional/header.php'; ?>
    <main class="flex-start-full">
        <section class=" h-100  z-1 w-100 p-3 ">
            <div class="row ">
                <div class="col-9">
                    <div>
                        <h1 class="fw-bold">Panel administrativo</h1>
                        <div class="d-flex justify-content-between">
                            <div>
                                <button class="button__orange"><a href="../../php/admin/report.php" class="text-decoration-none text__white">Reporte en <b>PDF</b></a></button>
                            </div>
                        </div><br>
                        <div class="show-patients d-flex   flex-column">
                            <div class="card-patient shadow">
                                <br>
                                <div class="card-patient__img flex-center-full">
                                    <img src="../../img/patients/childs/girl.png" class="" alt="">
                                </div>
                                <div class="card-patiente_information ">
                                    <b>Usuario:</b><span> Yaneri</span><br>
                                    <b>Nombre:</b><span> Yaneri</span><br>
                                    <b>Apellido:</b> Perdomo<span></span><br>
                                    <b>Edad:</b><span> 10</span><br>
                                    <b>Ejercicios: </b><span>Lorem ipsum dolor sit amet, consectetur</span>
                                </div>
                                <hr>
                                <div class="card-patient__operation flex-center-full gap-4">
                                    <i class="bi bi-trash"></i>
                                    <i class="bi bi-person-lines-fill"></i>
                                    <i class="bi bi-calendar3"></i>
                                </div>

                            </div>
                            <hr>
                            <div class="d-flex justify-content-between px-2">
                                <i class="bi bi-caret-left-fill color-blue fs-2"></i>
                                <i class="bi bi-caret-right-fill color-blue fs-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div>
                        <a href="./patient/add.php" class="text-decoration-none w-100">
                            <button class="button__green w-100">
                            Agregar paciente
                        </button>
                        </a><hr>
                        <section class="historys">
                            <span class="text__green fs-4">Historial</span>
                        </section>    
                    
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include '../include/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous">
    </script>
    <script src="../js/validations/login.js" type="module"></script>
</body>

</html>