<?php

require_once 'app/init.php';
// Prüfen ob POST poll bzw choice befüllt wurde
if(isset($_POST['poll'], $_POST['choice'])) {
// Falls ja -> speichern in variablen
    $poll   = $_POST['poll'];
    $choice = $_POST['choice'];
// VoteQuery vorbereiten
// Befüllt werden die user, poll und choice Identifikatoren
// Placeholder für user poll(id) und choice(id)
// EXISTS => Anzahl der "row Counts".
// User id wird "gesucht". Hier aus $_SESSION
// choice(id) wird gesucht wo id = der post werte bzw poll = post werte.
// poll(id) wird überprüft ob ein user bereits an einer bestimmten poll teilgenommen hat.
// Limit 1
    $voteQuery = $db->prepare("
        INSERT INTO polls_answers (user, poll, choice)
            SELECT :user, :poll, :choice
            FROM polls
            WHERE EXISTS (
                SELECT id
                FROM polls
                WHERE id = :poll
                AND DATE(NOW()) BETWEEN starts AND ends)
            AND EXISTS (
                SELECT id
                FROM polls_choices
                WHERE id = :choice
                AND poll = :poll)
            AND NOT EXISTS (
                SELECT id
                FROM polls_answers
                WHERE user = :user
                AND poll = :poll)
            LIMIT 1
    ");
// Statement ausführen
    $voteQuery->execute([
        'user' => $_SESSION['user_id'],
        'poll' => $poll,
        'choice' => $choice
    ]);

    header('Location: poll.php?poll=' . $poll);
    exit();
}

header('Location: index.php');