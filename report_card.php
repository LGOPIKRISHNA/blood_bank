<form action="download_report.php" method="POST">
    <input type="hidden" name="username" value="<?php echo htmlspecialchars($username, ENT_QUOTES); ?>">
    <button type="submit" class="download-button">Download Report</button>
</form>