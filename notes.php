<?php
    $pageTitle = 'Notes | Notes App';
    require ('private/incHeader.php');
?>
<div class="application grid">
    <div class="col-1-3 no-pad note-list">
        <ul class="note-list-list">
            <?php

            require ('private/connect.php');

            $sql = 'SELECT `ID`, `Title`, `Content`, `LastModified` FROM Notes WHERE `UserID` = ? AND `Active` = 1 ORDER BY `LastModified` DESC';

            $stmt = $db->prepare($sql);
            $stmt->bind_param('s', $_SESSION['user_id']);
            $stmt->execute();
            $stmt->bind_result($id, $title, $content, $last_modified);

            while ($stmt->fetch()) {

                $time = $last_modified;

                $timestamp = date("d/m/y h:i:s a", strtotime($time));

                print '
                <li class="note-list-entry" id="note-'. $id . '">
                    <div class="note-list-id" hidden>
                        ' . $id . '
                    </div>
                    <div class="note-list-title">
                        ' . $title .'
                    </div>
                    <div class="note-list-desc">
                        ' . $content . '
                    </div>
                    <div class="note-list-date">
                        ' . $timestamp . '
                    </div>
                    <div class="note-list-date-timestamp" hidden>
                        ' . $time . '
                    </div>
                    <div class="note-list-date-full" hidden>
                        ' . date('l, jS \of F, Y, h:i:s A', strtotime($time)) . '
                    </div>
                </li>
                ';
            }

            $stmt->close();

            ?>
            <li class="note-list-add" id="note-'. $id . '">
                    <div class="note-list-add-text">
                        <span class="ui-icon ui-icon-plus"></span>
                        Create a new note
                    </div>
                </li>
        </ul>
    </div>
    <div class="col-2-3 note-content note-content-hidden">
        
    </div>
</div>

<script src="js/notes.js"></script>

<?php
    require ('private/incFooter.php');
?>