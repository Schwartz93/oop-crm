<?php 
// Connection einbinden
require_once 'app/init.php';
// Überprüfen ob der GET Parameter 'poll' Werte enthält. Falls nicht wird zur index.php weitergeleitet.
if(!isset($_GET['poll'])) {
    header('Location: index.php');
} else {
// Andernfalls wird bzw werden die Werte in $id gespeichert
        $id = (int)$_GET['poll'];
// Statement wird vorbereitet. Es werden die id und die fragen aus der polls tabelle selektiert
// wo die id der jenigen im GET (URL) entspricht
        $pollQuery = $db->prepare("
            SELECT id, question
            FROM polls
            WHERE id = :poll
            AND DATE(NOW()) BETWEEN starts AND ends
        ");
// Query wird ausgeführt. Die entsprechende id im Statement in den platzhalter gesetzt
        $pollQuery->execute([
            'poll' => $id
        ]);
// Ergebnis als objekt in $poll gespeichert       
        $poll = $pollQuery->fetchObject();
// Statement für die Antworten vorbereiten
        $answerQuery = $db->prepare("
            SELECT polls_choices.id AS choice_id, polls_choices.name AS choice_name
            FROM polls_answers
            JOIN polls_choices
            ON polls_answers.choice = polls_choices.id
            WHERE polls_answers.user = :user
            AND polls_answers.poll = :poll
        ");

        $answerQuery->execute([
            'user' => $_SESSION['user_id'],
            'poll' => $id
        ]);

// Wurde die Umfrage von einem user beendet?
        $completed = $answerQuery->rowCount() ? true : false;
// ABgewandeltes SQL Statement welches die Antwortverteilung in Prozent ausgeben soll
        if($completed) {
            $answersQuery = $db->prepare("
                SELECT 
                polls_choices.name,
                COUNT(polls_answers.id) * 100 / (
                    SELECT COUNT(*)
                    FROM polls_answers
                    WHERE polls_answers.poll = :poll) AS percentage
                FROM polls_choices
                LEFT JOIN polls_answers
                ON polls_choices.id = polls_answers.choice
                WHERE polls_choices.poll = :poll
                GROUP BY polls_choices.id
            ");
// Statement ausführen und :poll mit der enstprechenden $id befüllen
            $answersQuery->execute([
                    'poll' => $id
            ]);
// $row bekommt die Werte der Query der Reihe nach als Objekts zurück. 
// Solange $row einen Wert erhält wird dieser in das answers array eingetragen.
            while($row = $answersQuery->fetchObject()) {
                $answers[] = $row;
            }
// Falls nicht beendet wurde, werden die Antwortmöglichkeiten (choices) vorbereitet
        } else {
// Selektiert werden die id's, die choice id's (welche hier mit AS zu choice.id werden) sowie den namen aus der polls_choices table
// (inner) Join von der id in "polls" und dem feldern "poll" in "polls_choices".
// Join passiert dort wo die id von polls jener entspricht die über GET mitgegeben wird bzw in der URL zu jedem Poll steht
// Weiteres Kriterium ist,dass die momentane zeit (NOW()) innerhalb des starts bzw ends datums steht.
            $choicesQuery = $db->prepare("
                SELECT polls.id, polls_choices.id AS choice_id, polls_choices.name
                FROM polls
                JOIN polls_choices
                ON polls.id = polls_choices.poll
                WHERE polls.id = :poll
                AND DATE(NOW()) BETWEEN polls.starts AND polls.ends
            ");
// Statement ausführen und :poll mit der enstprechenden $id befüllen
            $choicesQuery->execute([
                'poll' => $id,
            ]);
// $row bekommt die Werte der Query der Reihe nach als Objekts zurück. 
// Solange $row einen Wert erhält wird dieser in das choices array eingetragen.
            while($row = $choicesQuery->fetchObject()) {
                $choices[] = $row;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/main.css">
    <title>Document</title>
</head>
<body>
<!-- Checkt ob die die Umfrage mit dem key $poll existiert oder nicht -->
    <?php if(!$poll): ?>    
        <p>That poll does not exist.</p>
    <?php else: ?>
    <div class="poll">
        <div class="poll-question">
<!-- Ausgabe der Frage -->
            <?php echo $poll->question; ?>
        </div>
<!-- Falls die Umfrage bereits gemacht wurde: Meldung -->
        <?php if($completed): ?>
            <p>You have completed this poll, thanks!</p>
<!-- Innerhalb einer unordered list wird ausgegeben welche Antwortmöglichkeiten gewählt wurden
        (in prozent aller user) -->
            <ul>
                <?php foreach($answers as $answer): ?>
                    <li><?php echo $answer->name . ' ';?>(<?php echo number_format($answer->percentage, 1); ?>%)</li>
                <?php endforeach; ?>
            </ul>
<!-- Ist die Umfrage nicht beendet bzw schon einmal beantwortet worden: Poll anbieten -->
        <?php else: ?>
            <?php if(!empty($choices)): ?>
            <form action="vote.php" method="post">
                <div class="poll-options">
<!-- Die Antwortmöglichkeiten mit einer foreach Schleife durchlaufen und ausgeben 
     $key wird verwendet um die input id zu befüllen zb c1, c2... etc
     Für jedes input field wird ein label ausgegeben. Auch hier wird der entsprechende key/index benötigt -->
                    <?php foreach($choices as $key => $choice): ?>
                        <div class="poll-option">
                            <input type="radio" name="choice" value="<?php echo $choice->choice_id; ?>" id="c<?php echo $key; ?>">
                            <label for="c<?php echo $key; ?>"><?php echo $choice->name; ?></label>
                        </div>
                    <?php endforeach; ?>

                </div>
                
                <input type="submit" value="Submit answer">
                <input type="hidden" name="poll" value="<?php echo $id; ?>">
            </form>
<!-- Sind keine ausständigen polls mehr vorhanden wird das in einer Meldung ausgegeben. -->
            <?php else: ?>
                <p>There are no choices right now.</p>
            <?php endif; ?>
        <?php endif;?>
    </div>
    <?php endif; ?>
</body>
</html>