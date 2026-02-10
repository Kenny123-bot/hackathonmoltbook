<?php require_once "core/db.php"; ?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Live Hackathon Leaderboard</title>
<style>
body { font-family: Arial, sans-serif; padding: 10px; background: #f5f5f5; }
h2 { text-align: center; color: #333; }
#leaderboard { margin-top: 20px; }

table { width: 100%; border-collapse: collapse; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
th, td { padding: 12px; text-align: center; border-bottom: 1px solid #ddd; }
th { background-color: #2c3e50; color: white; }
tr:nth-child(even) { background-color: #f9f9f9; }
.top1 { background-color: gold; font-weight: bold; }
.top2 { background-color: silver; font-weight: bold; }
.top3 { background-color: #cd7f32; font-weight: bold; }
a.project-link { text-decoration: none; color: #2980b9; font-weight: bold; }
@media(max-width:600px){ th, td { font-size: 14px; padding:8px; } }
</style>
</head>
<body>

<h2>🏆 Live Hackathon Leaderboard</h2>
<p style="text-align:center;">Updates every 5 seconds</p>

<div id="leaderboard"></div>

<script>
// AJAX function to fetch leaderboard
function loadLeaderboard() {
    fetch('ajax_leaderboard.php')
        .then(res => res.text())
        .then(html => document.getElementById('leaderboard').innerHTML = html);
}

// Initial load + auto refresh every 5 seconds
loadLeaderboard();
setInterval(loadLeaderboard, 5000);
</script>

</body>
</html>
