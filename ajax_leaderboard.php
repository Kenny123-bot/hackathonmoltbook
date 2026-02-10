<?php
require_once __DIR__ . "/core/db.php";


/* Fetch top projects + scores + breakdown */
$projects = $conn->query("
    SELECT 
        p.id, p.project_title, t.team_name, SUM(s.score) AS total_score,
        GROUP_CONCAT(CONCAT(c.name, ': ', s.score) SEPARATOR ' | ') AS breakdown
    FROM scores s
    JOIN projects p ON s.project_id = p.id
    JOIN teams t ON p.team_id = t.id
    JOIN criteria c ON s.criteria_id = c.id
    GROUP BY s.project_id
    ORDER BY total_score DESC
    LIMIT 20
");
?>

<table>
<tr>
    <th>Rank</th>
    <th>Project</th>
    <th>Team</th>
    <th>Total Score</th>
    <th>Score Breakdown</th>
</tr>

<?php
$rank = 1;
while($p = $projects->fetch_assoc()) {
    $class = '';
    if($rank == 1) $class = 'top1';
    elseif($rank == 2) $class = 'top2';
    elseif($rank == 3) $class = 'top3';
    
    echo '<tr class="'.$class.'">';
    echo '<td>#'.$rank.'</td>';
    echo '<td><a class="project-link" href="../participant/submit_project.php?id='.$p['id'].'">'.htmlspecialchars($p['project_title']).'</a></td>';
    echo '<td>'.htmlspecialchars($p['team_name']).'</td>';
    echo '<td>'.$p['total_score'].'</td>';
    echo '<td>'.htmlspecialchars($p['breakdown']).'</td>';
    echo '</tr>';
    $rank++;
}
?>
</table>
