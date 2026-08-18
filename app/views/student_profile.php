<!DOCTYPE html>
<html>
<head>
    <title>Adrian's Student Profile</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .profile {
            width: 60%;
            margin: 50px auto;
            background: white;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .info {
            margin: 15px 0;
            padding: 12px;
            background: #f8f8f8;
            border-radius: 8px;
        }

        .label {
            font-weight: bold;
        }

        .nav {
            text-align: center;
            margin-top: 30px;
        }

        .nav a {
            display: inline-block;
            margin: 8px;
            padding: 12px 20px;
            text-decoration: none;
            background: #333;
            color: white;
            border-radius: 8px;
        }

        .nav a:hover {
            background: #555;
        }
    </style>
</head>

<body>

<div class="profile">

    <h1>Student Profile</h1>

    <div class="info">
        <span class="label">Student ID:</span>
        <?= $student_id ?>
    </div>

    <div class="info">
        <span class="label">Name:</span>
        <?= $name ?>
    </div>

    <div class="info">
        <span class="label">Course:</span>
        <?= $course ?>
    </div>

    <div class="info">
        <span class="label">Year Level:</span>
        <?= $year ?>
    </div>

    <div class="info">
        <span class="label">Section:</span>
        <?= $section ?>
    </div>

    <div class="info">
        <span class="label">Email:</span>
        <?= $email ?>
    </div>

    <div class="nav">
       <a href="/lavalust/student">Home</a>
<a href="/lavalust/student/profile">Student Profile</a>
    </div>

</div>

</body>
</html>