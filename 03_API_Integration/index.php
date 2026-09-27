<?php
require "api.php";

$city = trim($_GET["city"] ?? "");
$weather = null;
$error = "";

if ($city !== "") {
    try {
        $weather = getWeatherByCity($city);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Weather API App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Weather API Integration</h1>

    <form method="GET">
        <input
            type="text"
            name="city"
            placeholder="Enter a city"
            value="<?= htmlspecialchars($city) ?>"
            required
        >
        <button type="submit">Get Weather</button>
    </form>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($weather): ?>
        <div class="card">
            <h2>
                <?= htmlspecialchars($weather["name"]) ?>
                <?php if ($weather["country"]): ?>
                    , <?= htmlspecialchars($weather["country"]) ?>
                <?php endif; ?>
            </h2>

            <p>
                Temperature:
                <strong>
                    <?= htmlspecialchars((string)$weather["temperature"]) ?>
                    <?= htmlspecialchars($weather["temperature_unit"]) ?>
                </strong>
            </p>

            <p>
                Feels like:
                <?= htmlspecialchars((string)$weather["feels_like"]) ?>
                <?= htmlspecialchars($weather["temperature_unit"]) ?>
            </p>

            <p>
                Wind speed:
                <?= htmlspecialchars((string)$weather["wind_speed"]) ?>
                <?= htmlspecialchars($weather["wind_unit"]) ?>
            </p>

            <p>
                Coordinates:
                <?= htmlspecialchars((string)$weather["latitude"]) ?>,
                <?= htmlspecialchars((string)$weather["longitude"]) ?>
            </p>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
