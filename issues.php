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
        $milestone = isset($i->milestone) ? $i->milestone->title : '';
        $assignee = isset($i->assignee) ? $i->assignee->login : '';

        $row = array(
            $milestone,
            $i->number,
            $i->state,
            $assignee,
            '"' . str_replace('"', '""', $i->title) . '"',
            '"' . str_replace(['"', "\r\n"], ['""', "\r"], $i->body) . '"'
        );

        echo implode(';', $row) . "\n";
    }
    fclose($file);
    ++$a;
}
