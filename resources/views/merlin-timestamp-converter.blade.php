<!DOCTYPE html>
<html>
<head>
    <title>Timestamp Converter</title>
</head>
<body>
    <form action="">
        <label for="inputX">Enter value for x:</label>
        <input type="text" id="inputX" name="inputX" required value="{{ request()->inputX }}">
        <input type="submit" value="Convert">
    </form>
    <p>
        <b>{{ App\Merlin\Tools::convertTimestamp(request()->inputX) }}</b>
    </p>
</body>
</html>