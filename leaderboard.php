<?php
require_once __DIR__ . "/core/db.php";

/* Fetch top projects with totals */
$sql = "
    SELECT p.project_title, t.team_name, SUM(s.score) AS total_score
    FROM scores s
    JOIN projects p ON s.project_id = p.id
    JOIN teams t ON p.team_id = t.id
    GROUP BY s.project_id
    ORDER BY total_score DESC
    LIMIT 20
";
$projects = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>🏆 Live Hackathon Leaderboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Auto-refresh every 10 seconds (soft refresh via JS) -->
    <meta http-equiv="refresh" content="10">

    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #e8ecf1);
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        p {
            text-align: center;
            color: #666;
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }

        th, td {
            padding: 14px 10px;
            text-align: center;
        }

        th {
            background: #2c3e50;
            color: #fff;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.05em;
        }

        tr {
            transition: background 0.25s ease, transform 0.2s ease;
        }

        tr:hover {
            background: #f1f6ff;
            transform: scale(1.01);
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        /* Top 3 styling */
        .top1 { background: linear-gradient(90deg, #ffd700, #ffec8b); font-weight: bold; }
        .top2 { background: linear-gradient(90deg, #c0c0c0, #e0e0e0); font-weight: bold; }
        .top3 { background: linear-gradient(90deg, #cd7f32, #e6b17e); font-weight: bold; }

        .rank {
            font-size: 18px;
            font-weight: bold;
        }

        .score {
            font-size: 16px;
            font-weight: bold;
            color: #27ae60;
        }

        @media(max-width: 600px) {
            th, td {
                padding: 10px 6px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<h2>🏆 Live Hackathon Leaderboard</h2>
<p>Auto-updates every 10 seconds</p>

<table>
    <tr>
        <th>Rank</th>
        <th>Project</th>
        <th>Team</th>
        <th>Total Score</th>
    </tr>

    <?php
    $rank = 1;
    while ($p = $projects->fetch_assoc()):
        $class = '';
        if ($rank === 1) $class = 'top1';
        elseif ($rank === 2) $class = 'top2';
        elseif ($rank === 3) $class = 'top3';
    ?>
    <tr class="<?= $class ?>">
        <td class="rank">
            <?= $rank === 1 ? '🥇' : ($rank === 2 ? '🥈' : ($rank === 3 ? '🥉' : "#$rank")) ?>
        </td>
        <td><?= htmlspecialchars($p['project_title']) ?></td>
        <td><?= htmlspecialchars($p['team_name']) ?></td>
        <td class="score"><?= (int)$p['total_score'] ?></td>
    </tr>
    <?php
        $rank++;
    endwhile;
    ?>
</table>

</body>
</html>
