<?php
$dataset = "";
$players = [];
$teamOpt = [];

function getDelta($players, $team1): float
{
    $score1 = $score2 = 0.0;

    foreach ($players as $name => $score) {
        if (in_array($name, $team1)) {
            $score1 += $score;
        } else {
            $score2 += $score;
        }
    }

    return abs($score1 - $score2);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dataset = $_POST['dataset'];

    foreach (preg_split("|\\r?\\n|", $dataset) as $row) {
        $arr = preg_split("|\\s+|", $row);
        $players[$arr[0]] = floatval(preg_replace("|,|", ".", $arr[1]));
    }
    arsort($players);

    $numPlayers = floor(count($players) / 2); // сколько забрать в 1ю команду
    $minDelta = null;

    for ($i = 0; $i < 2 ** count($players); $i++) {
        $dec = str_pad(decbin($i), count($players), "0", STR_PAD_LEFT);

        $team1 = [];
        for ($j = 0; $j < count($players); $j++) {
            if (substr($dec, $j, 1) === '0') {
                $team1[] = array_keys($players)[$j];
            }
        }

        if ($numPlayers != count($team1)) {
            continue;
        }

        $delta = getDelta($players, $team1);
        if ($minDelta === null || $delta < $minDelta) {
            $minDelta = $delta;
            $teamOpt = $team1;
        }
    }
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Футбольная Лига</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>
<body>
<div class="container" style="max-width: 600px">
    <form method="post">
        <div class="my-3">
            <textarea name="dataset" rows="12" class="form-control"
                      placeholder="1 строка на игрока"><?= $dataset ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Рассчитать</button>
    </form>

    <?php if ($teamOpt) : ?>
        <h3 class="mt-4">Возможное разделение команд:</h3>

        <div class="row">
            <div class="col-sm-6">
                <table>
                    <thead>
                    <tr>
                        <th colspan="2">Команда1</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $ttl1 = 0.0; ?>
                    <?php foreach ($players as $name => $score): ?>
                        <?php if (in_array($name, $teamOpt)) : ?>
                            <tr>
                                <td style="min-width: 100px"><?php echo $name ?></td>
                                <td><?php echo $score ?></td>
                            </tr>
                            <?php $ttl1 += $score ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="col-sm-6">
                <table>
                    <thead>
                    <tr>
                        <th colspan="2">Команда2</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $ttl2 = 0.0; ?>
                    <?php foreach ($players as $name => $score): ?>
                        <?php if (!in_array($name, $teamOpt)) : ?>
                            <tr>
                                <td style="min-width: 100px"><?php echo $name ?></td>
                                <td><?php echo $score ?></td>
                            </tr>
                            <?php $ttl2 += $score ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <p class="text-muted text-center my-4">Разница <?php echo abs($ttl1 - $ttl2) ?></p>
    <?php endif ?>
</div>
</body>
</html>
