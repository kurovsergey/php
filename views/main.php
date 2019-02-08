<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Main form</title>
    <link rel="stylesheet" type="text/css" href="/public/css/styles.css"/>
    <script
        src="//code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
</head>
<body>
<form name="main" action="/index.php" method="post">
    <input type="hidden" value="sendUserData" name="action"/>
    <div>
        <label>Name:</label><input type="text" name="name"/>
    </div>
    <div>
        <label>E-mail:</label><input type="email" name="email"/>
    </div>
    <div><input type="submit" value="Send"/></div>
</form>
<div id="result"></div>
<script src="/public/js/scripts.js"></script>
</body>
</html>