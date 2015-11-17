<?php
// issues.php
$a = 1;
$b = true;
echo "\xEF\xBB\xBF";
echo "Milestone" . ";" . "Issue Number" . ";" . "State" . ";" . "Assignee" . ";" . "Title" . ";" . "Body" . "\n";
while ($b) {

    if(file_exists('issue' . $a . '.json')) {
        $file = fopen('issue' . $a . '.json', 'r');
    } else {
        $b = false;
        break;
    }
    $content = fread($file, filesize('issue'.$a.'.json'));
    $issues = json_decode($content);

// I retrieve milestone, issue number, state, title and description
    foreach ($issues as $i) {
        if (isset($i->assignee->login) && isset($i->milestone->title)) {
            echo $i->milestone->title . ";" . $i->number . ";" . $i->state . ";" . $i->assignee->login . ";" . $i->title . ";" . preg_replace("/(\r\n|\n|\r)/", " ", $i->body) . "\n";
        } else if (isset($i->milestone)) {
            echo $i->milestone->title . ";" . $i->number . ";" . $i->state . ";" . " " . ";" . $i->title . ";" . preg_replace("/(\r\n|\n|\r)/", " ", $i->body) . "\n";
        } else if (isset($i->assignee)){
            echo " " . ";" . $i->number . ";" . $i->state . ";" . $i->assignee->login . ";" . $i->title . ";" . preg_replace("/(\r\n|\n|\r)/", " ", $i->body) . "\n";
        } else {
            echo " " . ";" . $i->number . ";" . $i->state . ";" . " " . ";" . $i->title . ";" . preg_replace("/(\r\n|\n|\r)/", " ", $i->body) . "\n";
        }
    }
    ++$a;
}
