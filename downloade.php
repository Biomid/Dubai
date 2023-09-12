<?php
require_once "db/functions.php";
session_start();

define("CONNECT", db_connect());

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/my.css">
    <link rel="stylesheet" href="css/upload%20form.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
    <link rel="stylesheet" href="css/table.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Document</title>
</head>
<body>
<main>
    <header class="p-3 mb-3 border-bottom ">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                        <use xlink:href="#bootstrap"/>
                    </svg>
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="#" class="nav-link px-2 link-secondary">Overview</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark">Inventory</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark">Customers</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark">Products</a></li>
                </ul>

                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                    <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
                </form>

                <div class="dropdown text-end">
                    <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <img src="img/avatar/start%20photo.avif" alt="mdo" width="32" height="32"
                             class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu text-small">
                        <li><a class="dropdown-item" href="#">New project...</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
</main>
<section class="h-100 gradient-custom-2 section">

    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9 col-xl-7 wrapper">
                <div class="tab">
                    <button id="defaultOpen" class="tablinks" onclick="openCity(event, 'London')">Профиль</button>
                    <button class="tablinks" onclick="openCity(event, 'Paris')">Создать</button>
                    <button class="tablinks" onclick="openCity(event, 'Tokyo')">Меню</button>
                </div>
                <div style="display: block; " id="London" class="card tabcontent">

                    <div class="rounded-top text-white d-flex flex-row" style="background-color: #000; height:200px;">
                        <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
                            <img src="img/avatar/Fikh.jpg"
                                 alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2"
                                 style="width: 150px; z-index: 1">
                            <button type="button" class="btn btn-outline-dark" data-mdb-ripple-color="dark"
                                    style="z-index: 1;">
                                Edit profile
                            </button>
                        </div>
                        <div class="ms-3" style="margin-top: 130px;">
                            <h5><?=$_SESSION['user']['name']." ".$_SESSION['user']['sname'];?></h5>
                            <form>
                            <input type="hidden" name="Name" value="<?=$_SESSION['user']['name']." ".$_SESSION['user']['sname'];?>">
                            </form>
                            <p>id: #<?=$_SESSION['user']['uid']?></p>
                        </div>
                    </div>
                    <div class="p-4 text-black" style="background-color: #f8f9fa;">
                        <div class="d-flex justify-content-end text-center py-1">
                            <div>
                                <p class="mb-1 h5">1</p>
                                <p class="small text-muted mb-0">Aparts</p>
                            </div>
                            <div class="px-3">
                                <p class="mb-1 h5">70%</p>
                                <p class="small text-muted mb-0">occupancy</p>
                            </div>
                            <div>
                                <p class="mb-1 h5">478</p>
                                <p class="small text-muted mb-0">Earned</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4 text-black">
                        <div class="mb-5">
                            <p class="lead fw-normal mb-1">Upload files</p>
                            <div class="p-4 reload-file" style="background-color: #f8f9fa;">
                                <?php
                                    $insert_query = "SELECT * FROM `upload_file` WHERE `uid` LIKE ?";
                                    $data = CONNECT->prepare($insert_query);
                                    $data->execute([$_SESSION['user']['uid']]);

                                    $row = $data->rowCount();

                                    if ($row > 0){
                                        $result = $data->fetchAll(PDO::FETCH_ASSOC);

                                ?>
                                        <div class="container" style=" overflow-y: scroll; height: 300px;">
                                            <div class="row justify-content-center">
                                                <div class="col-12">
                                                    <div class="table-responsive bg-white">
                                                        <table class="table mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col" style="color: #666666;">File name</th>
                                                                <th scope="col" style="color: #666666;">Upload date</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php  foreach ($result as $key =>$value){?>
                                                                <tr>
                                                                    <th scope="row" style="color: #666666;"><?=$value['file_name']?></th>
                                                                    <td><?=$value['upload_data']?></td>
                                                                </tr>
                                                            <?php }?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php

                                    }
                                    else {
                                ?>
                                        <p class="font-italic mb-1">No data</p>

                                <?php }?>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <p class="lead fw-normal mb-0">Upload new file</p>
                            <p class="mb-0"><a href="#!" class="text-muted">help</a></p>
                        </div>
                        <div class="my-upload-form">
                            <form enctype="multipart/form-data">
                            <div class="file-upload">
                                <div class="file-select">
                                    <div class="file-select-button" id="fileName">Choose File</div>
                                    <div class="file-select-name" id="noFile">No file chosen...</div>
                                    <input type="file" name="my_file" id="chooseFile">
                                </div>
                            </div>
                                <button class="w-50 btn btn-lg btn-primary btn-auto upload-btn" type="submit">Upload</button>
                            </form>
                            <div class="mess">
                                <div class="alert alert-success good" role="alert">

                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <p class="lead fw-normal mb-0">Information about the apartment</p>
                        </div>
                        <div class="container mt-5">
                            <div class="slect-container" style="margin-bottom: 15px;">
                            <select class="form-select" aria-label="Default select example" autofocus="autofocus">
                                <option></option>
                                <?php $insert_query = "SELECT DISTINCT `apart_name` FROM `file_data` WHERE `owner` = ?";
                                $data = CONNECT->prepare($insert_query);
                                $data->execute([$_SESSION['user']['name']." ".$_SESSION['user']['sname']]);
                                $row = $data->rowCount();
                                if ($row > 0){
                                    $result = $data->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $key => $value){
                                ?>
                                <option value="<?=$value['apart_name']?>"><?=$value['apart_name']?></option>
                                <?php }
                                }?>
                            </select>
                            </div>
                        </div>
                        <div class="mb-5" id="hide-info" style="display: none">
                            <div class="p-4 reload owner-info-table" style="background-color: #f8f9fa;">
                                <div class="container" style=" overflow-y: scroll; height: 180px;">
                                    <div class="row justify-content-center">
                                        <div class="col-12">
                                            <div class="table-responsive bg-white">
                                                <table id="owner-info-table" class="table mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col" style="color: #666666;">Apart name</th>
                                                        <th scope="col" style="color: #666666;">Price for 1 night</th>
                                                        <th scope="col" style="color: #666666;">Amount to be paid</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <p class="lead fw-normal mb-0">Chart info</p>
                        </div>
                        <div id="carouselExample" class="carousel slide carousel-reload" style="display: block">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                        <canvas id="myChart" class="canv d-block w-100"></canvas>
                                </div>
                                <div class="carousel-item">
                                        <canvas id="myChart2" class="canv d-block w-100"></canvas>
                                </div>
                            </div>
                            <button class="carousel-control-prev my_btn" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next my_btn" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        <!-- Кнопка-триггер модального окна -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin-top: 15px">
                            Запустите демо модального окна
                        </button>

                        <!-- Модальное окно -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-fullscreen">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Итоговые данные</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container-table" style="width: 97%">
                                            <table id="owner-info-table-full">
                                                <thead>
                                                <tr>
                                                    <th>Owner</th>
                                                    <th>Apart name</th>
                                                    <th>Month</th>
                                                    <th>Nights of rent</th>
                                                    <th>Price for night</th>
                                                    <th>Occupancy %</th>
                                                    <th>Rental amount</th>
                                                    <th>DEWA</th>
                                                    <th>DU</th>
                                                    <th>Empower...</th>
                                                    <th>Operation expense</th>
                                                    <th>Cleaning</th>
                                                    <th>GAZ</th>
                                                    <th>DTCM</th>
                                                    <th>Owner's outstanding</th>
                                                    <th>Autl or Fix</th>
                                                    <th>%</th>
                                                    <th>Amount</th>
                                                    <th>VAT 5%</th>
                                                    <th>Total commission</th>
                                                    <th>Amount to be paid</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                                        <button type="button" class="btn btn-primary">Сохранить изменения</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!--                ТЕСТИМ ВКЛАДКИ-->
                <div style="display: none; " id="Paris" class="card tabcontent">

                    <div class="rounded-top text-white d-flex flex-row" style="background-color: #000; height:200px;">
                        <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
                            <img src="img/avatar/start%20photo.avif"
                                 alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2"
                                 style="width: 150px; z-index: 1">
                            <button type="button" class="btn btn-outline-dark" data-mdb-ripple-color="dark"
                                    style="z-index: 1;">
                                Edit profile
                            </button>
                        </div>
                        <div class="ms-3" style="margin-top: 130px;">
                            <h5><?=$_SESSION['user']['name']." ".$_SESSION['user']['sname'];?></h5>
                            <form>
                                <input type="hidden" name="Name" value="<?=$_SESSION['user']['name']." ".$_SESSION['user']['sname'];?>">
                            </form>
                            <p>id: #12366134</p>
                        </div>
                    </div>
                    <div class="p-4 text-black" style="background-color: #f8f9fa;">
                        <div class="d-flex justify-content-end text-center py-1">
                            <div>
                                <p class="mb-1 h5">70</p>
                                <p class="small text-muted mb-0">Users</p>
                            </div>

                        </div>
                    </div>
                    <div class="card-body p-4 text-black">
                        <div class="mb-5">
                            <p class="lead fw-normal mb-1">User(owners)</p>
                            <div class="p-4 reload-user" style="background-color: #f8f9fa;">
                                <?php
                                $insert_query = "SELECT * FROM `users`";
                                $data = CONNECT->prepare($insert_query);
                                $data->execute();
                                $row = $data->rowCount();
                                if ($row > 0){
                                    $result = $data->fetchAll(PDO::FETCH_ASSOC);
                                ?>
                                        <div class="container" style=" overflow-y: scroll; height: 300px;">
                                            <div class="row justify-content-center">
                                                <div class="col-12">
                                                    <div class="table-responsive bg-white">
                                                        <table class="table mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col" style="color: #666666;">NAME</th>
                                                                <th scope="col" style="color: #666666;">EMAIL</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php  foreach ($result as $key =>$value){?>
                                                            <tr>
                                                                <th scope="row" style="color: #666666;"><?=$value['name']." ".$value['sname']?></th>
                                                                <td><?=$value['email']?></td>
                                                            </tr>
                                                            <?php }?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                }
                                else{
                                ?>
                                <p class="font-italic mb-1">asd</p>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="my-upload-form">
                            <form>
                                <h1 class="h3 mb-3 fw-normal">Create new user</h1>

                                <div class="form-floating">
                                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="Create-email">
                                    <label for="floatingInput">Email address</label>
                                </div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingInput" placeholder="Password"
                                           name="Create-name">
                                    <label for="floatingPassword">Name</label>
                                </div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingInput" placeholder="Password"
                                           name="Create-sname">
                                    <label for="floatingPassword">SName</label>
                                </div>
                                <button class="w-50 btn btn-lg btn-primary btn-auto create-user" type="submit">Upload</button>
                            </form>
                            <div class="mess-2">
                                <div class="alert alert-success good-2" role="alert">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--                ТЕСТИМ ВКЛАДКИ-->
                <div style="display: none; " id="Tokyo" class="card tabcontent">

                    <div class="rounded-top text-white d-flex flex-row" style="background-color: #000; height:200px;">
                        <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
                            <img src="img/avatar/start%20photo.avif"
                                 alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2"
                                 style="width: 150px; z-index: 1">
                            <button type="button" class="btn btn-outline-dark" data-mdb-ripple-color="dark"
                                    style="z-index: 1;">
                                Edit profile
                            </button>
                        </div>
                        <div class="ms-3" style="margin-top: 130px;">
                            <h5><?=$_SESSION['user']['name']." ".$_SESSION['user']['sname'];?></h5>
                            <form>
                                <input type="hidden" name="Name" value="<?=$_SESSION['user']['name']." ".$_SESSION['user']['sname'];?>">
                            </form>
                            <p>id: #12366134</p>
                        </div>
                    </div>
                    <div class="p-4 text-black" style="background-color: #f8f9fa;">
                        <div class="d-flex justify-content-end text-center py-1">
                            <div>
                                <p class="mb-1 h5">253</p>
                                <p class="small text-muted mb-0">Photos</p>
                            </div>
                            <div class="px-3">
                                <p class="mb-1 h5">1026</p>
                                <p class="small text-muted mb-0">Followers</p>
                            </div>
                            <div>
                                <p class="mb-1 h5">478</p>
                                <p class="small text-muted mb-0">Following</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4 text-black">
                        <div class="mb-5">
                            <p class="lead fw-normal mb-1">Menu</p>
                            <div class="p-4" style="background-color: #f8f9fa;">
                                <div class="calendar">
                                    <form class="menu-form">
                                        <fieldset>
                                            <legend>Date start...</legend>
                                            <input type="month" name="datastart">
                                            <input type="month" name="dataend">
                                        </fieldset>
                                        <div class="select-container-owner" style="margin-bottom: 15px; margin-top: 15px">
                                            <select name="owner" id="apart-owner" multiple>
                                            </select>
                                        </div>
                                        <div class="select-container-apart" style="margin-bottom: 15px; margin-top: 15px">
                                            <select name="apart" id="apart-name" multiple >
                                            </select>
                                        </div>
                                        <button class="menu-btn" type="submit">Send</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <p class="lead fw-normal mb-0">Data</p>
                            <p class="mb-0"><a href="#!" class="text-muted">help</a></p>
                        </div>

                        <div class="mb-5">
                            <div class="p-4 reload" style="background-color: #f8f9fa;">
                                    <div class="container" style=" overflow-y: scroll; height: 300px;">
                                        <div class="row justify-content-center">
                                            <div class="col-12">
                                                <div class="table-responsive bg-white">
                                                    <table id="apart-info-table" class="table mb-0">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col" style="color: #666666;">NAME</th>
                                                            <th scope="col" style="color: #666666;">Apart</th>
                                                            <th scope="col" style="color: #666666;">Month</th>
                                                            <th scope="col" style="color: #666666;">Nights</th>
                                                            <th scope="col" style="color: #666666;">NET</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="my-upload-form">
                            <!-- Кнопка-триггер модального окна -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalAdmin">
                                Запустите демо модального окна
                            </button>

                            <!-- Модальное окно -->
                            <div class="modal fade" id="exampleModalAdmin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-fullscreen">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Итоговые данные</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container-table" style="width: 97%">
                                                <table id="apart-info-table-full">
                                                    <thead>
                                                    <tr>
                                                        <th>Owner</th>
                                                        <th>Apart name</th>
                                                        <th>Month</th>
                                                        <th>Nights of rent</th>
                                                        <th>Price for night</th>
                                                        <th>Occupancy %</th>
                                                        <th>Rental amount</th>
                                                        <th>DEWA</th>
                                                        <th>DU</th>
                                                        <th>Empower...</th>
                                                        <th>Operation expense</th>
                                                        <th>GAZ</th>
                                                        <th>DTCM</th>
                                                        <th>Owner's outstanding</th>
                                                        <th>%</th>
                                                        <th>Amount</th>
                                                        <th>VAT 5%</th>
                                                        <th>Total commission</th>
                                                        <th>Amount to be paid</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                                            <button type="button" class="btn btn-primary">Сохранить изменения</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mess">
                                <div class="alert alert-success good" role="alert">

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="js/jquery.js"></script>
<script src="js/select.js"></script>
<script src="js/upload.js"></script>
<script src="js/chart.js"></script>
<script src="js/index.js"></script>
<script src="js/switch%20page.js"></script>
</body>
</html>
