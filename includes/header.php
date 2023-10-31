<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project MM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href='<?php
    if (file_exists('./../includes/favicon.png')) {
        print('./../includes/favicon.png');
    } else if (file_exists('favicon.png')) {
        print('favicon.png');
    } else if (file_exists('includes/favicon.png')) {
        print('includes/favicon.png');
    }
    ?>' />
    <style>
        body {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            print-color-adjust: exact;

            display: flex;
            flex-direction: column;
            min-height: 100vh;

            font-family: 'Roboto', 'Lato', sans-serif;

            background-image:url(<?php
            if (file_exists('./../includes/background.jpg')) {
                print('./../includes/background.jpg');
            } else if (file_exists('background.jpg')) {
                print('background.jpg');
            } else if (file_exists('includes/background.jpg')) {
                print('includes/background.jpg');
            } ?>);

            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
        }

        main {
            flex-grow: 1;
        }

        footer {
            bottom: 0;
            position: sticky;
            /* set background opacity: */
            background-color: rgba(255, 255, 255, 0.2);
        }

        header {
            position: sticky;
            top: 0;
            /* set background opacity: */
            background-color: rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body>