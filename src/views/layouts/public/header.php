<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/reset.css">
    <link rel="stylesheet" href="public/css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;400;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="public/images/favicon.png">
    <title><?= $title; ?> | Movies</title>
</head>

<body>
    <header>
        <div class="containerbody">
            <div><img src="public/images/boxoffice.png" alt=""></div>
            <div class="wrapper">
                <div class="container">
                    <form class="search">
                        <input type="text" id="search" placeholder="Rechercher un film, une série, un acteur... ">
                        <button id="wen"><img src="public/images/loupe.png" alt=""></button>
                    </form>
                    <div class="connect">
                        <div class="center">
                            <img src="public/images/user.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div><img src="public/images/cinefan.png" alt=""></div>
        </div>
    </header>