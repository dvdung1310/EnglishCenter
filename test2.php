<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .checkbox {
            display: none;
            /* Ẩn checkbox gốc */
        }

        .checkbox+label {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #999;
            border-radius: 50%;
            cursor: pointer;
        }

        .green:checked+label {
            background-color: #3cb371;
            /* Màu xanh */
            border-color: #3cb371;
        }

        .green:checked+label::after {
            content: "\2713";
            /* Dấu tích unicode */
            color: #fff;
            font-size: 14px;
            text-align: center;
            line-height: 20px;
        }

        label::after {
            content: "";
            display: block;
            width: 100%;
            height: 100%;
            text-align: center;
            line-height: 20px;
        }

        .red:not(:checked)+label {
            background-color: #ff0000;
            /* Màu đỏ */
            border-color: #ff0000;
        }
    </style>
</head>

<body>
    <input type="checkbox" class="checkbox <?php echo ($data == 1) ? 'green' : 'red'; ?>" id="myCheckbox">
    <label for="myCheckbox"></label>
</body>

</html>