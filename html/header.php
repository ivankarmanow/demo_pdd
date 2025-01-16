<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? "Главная" ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"></script>
    <style>
        @media (max-width: 560px) {
            #admin-filter {
                flex-direction: column;
            }
        }
    </style>
    <script src="/js/<?= $template ?>.js"></script>
    <link rel="stylesheet" href="/css/<?= $template ?>.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-info sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Нарушениям.НЕТ</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Переключатель навигации">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
            <ul class="navbar-nav me-0 mb-2 mb-lg-0 gap-2">
                <!--                <li class="nav-item">-->
                <!--                    <a class="nav-link active" aria-current="page" href="/">Главная</a>-->
                <!--                </li>-->
                <li class="nav-item">
                    <button class="btn btn-primary" onclick="window.location.href = '/new_form'">Создать заявку</button>
                </li>
                <?php if ($_SESSION['is_admin'] ?? false) { ?>
                    <li class="nav-item">
                        <button class="btn btn-primary" onclick="window.location.href = '/admin'">Панель
                            администратора
                        </button>
                    </li>
                <?php } ?>
            </ul>
            <ul class="navbar-nav me-0 mb-2 mb-lg-0 gap-2">
                <?php if (isset($_SESSION['user_id'])) { ?>
                    <li class="nav-item navbar-text">
                        <span><?= $_SESSION['name'] ?></span>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-primary" onclick="window.location.href = '/logout'">Выйти</button>
                    </li>
                <?php } else if ($_SESSION['is_admin'] ?? false) { ?>
                    <li class="nav-item navbar-text">
                        <span>Администратор</span>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-primary" onclick="window.location.href = '/logout'">Выйти</button>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <button class="btn btn-primary" onclick="window.location.href = '/login_form'">Вход</button>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-primary" onclick="window.location.href = '/reg_form'">Регистрация
                        </button>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-4">