<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK Matrimonials</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=Roboto:wght@300&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/86bcaea8d5.js" crossorigin="anonymous"></script>
    </script>

    <!-- Favicon -->
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
            font-family: 'Roboto', 'Lato', sans-serif !important;

            background-image: url(<?php
            if (file_exists('./../includes/background.jpeg')) {
                print('./../includes/background.jpeg');
            } else if (file_exists('background.jpeg')) {
                print('background.jpeg');
            } else if (file_exists('includes/background.jpeg')) {
                print('includes/background.jpeg');
            } ?>) !important;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;

            color: white !important;
            /* Text color in dark theme */
            background-color: #333333;
            /* Background color in dark theme */
        }

        main {
            flex-grow: 1;
        }

        input[type="text"]+label,
        input[type="email"]+label,
        input[type="number"]+label,
        input[type="password"]+label {
            color: black !important;
        }

        header {
            position: sticky;
            left: 0;
            top: 0;
            width: 100%;
            background: #222222;
            /* Header background color in dark theme */
            color: #ffffff;
            /* Header text color in dark theme */
        }

        footer {
            font-size: 15px;
            left: 0;
            bottom: 0;
            width: 100%;

            background: #222222;
            /* Footer background color in dark theme */
            color: #ffffff;
            /* Footer text color in dark theme */
        }

        table,
        th,
        td,
        tbody,
        thead {
            background-color: rgba(0, 0, 0, 0.1) !important;
            color: white !important;
        }

        .w-100,
        .btn-lg {
            margin-bottom: 35px;
        }

        ::-webkit-scrollbar {
            width: 15px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: black;
        }

        ::-webkit-scrollbar-thumb {
            border-radius: 20px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: lightblue;
            border-radius: 20px;
            border: 6px solid transparent;
            background-clip: content-box;
        }

        /* nav {
            background-color: black;
        } */

        /* Select links in the navbar */
        .navbar a {
            color: white !important;
        }

        .navbar button {
            background-color: #595959 !important;
        }

        /* Select link hover effects */
        .navbar a:hover {
            color: lightblue !important;
        }

        .dropdown-menu a {
            color: black !important;
        }

        .dropdown-menu a:hover {
            color: black !important;
        }
    </style>
</head>

<body>