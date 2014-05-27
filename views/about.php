<?php $title = 'About' ?>

<?php ob_start() ?>

    <p>Management of my co-ed softball team was thrust upon me one day. To fulfill the team's purpose
    of making sure everyone got a fair amount of play time and access to preferred field positions,
    I had to develop a marginally sophisticated spreadsheet. One weekend, I even got bored and started
    writing a script to parse my lineup/schedule sheet and put it in graphical form: An image of a
    softball field with player names at all the positions. I thought I'd like to share that work or
    at the very least to make it more robust. Thus what you have before you.</p>

    <p>The app is still under heavy development and most of the features are currently broken. I could
    put up an old, seemingly-more-complete revision but since I had a couple bugs due to PHP delopment/production version mismatches,
    I'd rather just leave up what I have. And because the project is a little ambitious, I'm actually going
    to scale back the features targeted for whatever hypothetical future release might happen, starting with
    just a simple lineup editor.</p>

<?php $content = ob_get_clean() ?>

<?php require 'templates/layout.php' ?>
