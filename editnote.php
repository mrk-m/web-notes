<?php

function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = htmlentities($data);
    return $data;
}

session_start();

if (isset($_SESSION['user_id'])) {

    require ("private/connect.php");

    $note_id = clean_input($_POST['id']);
    $note_title = clean_input($_POST['title']);
    $note_content  = clean_input($_POST['content']);
    $note_time  = clean_input($_POST['time']);
    $user_id = clean_input($_SESSION['user_id']);

    $sql_check = 'SELECT UserID FROM Notes WHERE ID = ?';

    $stmt_check = $db->prepare($sql_check);
    $stmt_check->bind_param('s', $note_id);
    $stmt_check->execute();
    $stmt_check->bind_result($userid);


    // Check if there is already a note with this id
    if ($stmt_check->fetch() || $note_id != '-1') {
        $stmt_check->close();
        // Edit note if this note is owned by the user
        if ($user_id == $userid) {
            $sql_edit = 'UPDATE Notes SET Title = ?, Content = ?, LastModified = ? WHERE ID = ?';
            $stmt_edit = $db->prepare($sql_edit);
            $stmt_edit->bind_param('ssss', $note_title, $note_content, $note_time, $note_id);
            $stmt_edit->execute();
        } 
    } else {
        $stmt_check->close();
        // Create a new note
        $sql_create = 'INSERT INTO Notes (UserID, Title, Content) VALUES (?, ?, ?)';
        $stmt_create = $db->prepare($sql_create);
        $stmt_create->bind_param('sss', $user_id, $note_title, $note_content);
        $stmt_create->execute();
    }
} else {
    header("Location: index");
}

header("Location: notes");
?>