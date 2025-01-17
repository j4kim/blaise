<!DOCTYPE html>
<html>
<head>
    <title>Timestamp Converter</title>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $x = intval($_POST['inputX']);
        $ts = intval(6.3115e8 + 0.86402 * $x);
        $date = date("d.m.Y H:i", $ts);
    }
    ?>

    <form method="post" action="">
        <label for="inputX">Enter value for x:</label>
        <input type="text" id="inputX" name="inputX" required value="<?= $_POST['inputX'] ?? '' ?>">
        <input type="submit" value="Convert">
    </form>
    <p>
        <b><?= $date ?></b>
    </p>
</body>
</html>