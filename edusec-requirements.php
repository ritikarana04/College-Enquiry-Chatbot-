<?php


/**
 * Requirement checker for yii2 application script.
 */

$chekerPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'components';
$chkDbFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'db.php';
require_once($chekerPath . DIRECTORY_SEPARATOR. 'EdusecRequirementChecker.php');
$requirementsChecker = new EdusecRequirementChecker();

$resultsData = $requirementsChecker->getResult(); 
$summary = $resultsData['summary'];
$requiredData = $resultsData['requirements'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Application Requirement Checker</title>
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="vendor/bower/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="header">
        <h1><sup style="top: -1.5em;font-size: 12px;">TM</sup> Application Requirement Checker</h1>
    </div>
    <hr>

    <div class="content">
        <h3>Description</h3>
        <p>
        This script checks if your server configuration meets the requirements
        for running Yii/application.
        It checks if the server is running the right version of PHP,
        if appropriate PHP extensions have been loaded, and if php.ini file settings are correct.
        </p>
        <p>
        There are two kinds of requirements being checked. Mandatory requirements are those that have to be met
        to allow Yii to work as expected. There are also some optional requirements being checked which will
        show you a warning when they do not meet. You can use Yii framework without them but some specific
        functionality may be not available in this case.
        </p>

        <h3>Conclusion</h3>
        <?php if ($summary['errors'] > 0): ?>
            <div class="alert alert-danger">
                <strong>Unfortunately your server configuration does not satisfy the requirements by this application.<br>Please refer to the table below for detailed explanation.</strong>
		  <strong><br><br>Please fix following errors then install </strong>
            </div>
        <?php elseif ($summary['warnings'] > 0): ?>
            <div class="alert alert-info">
                <strong>Your server configuration satisfies the minimum requirements by this application.<br>Please pay attention to the warnings listed below and check if your application will use the corresponding features.</strong>
            </div>
        <?php else: ?>
            <div class="alert alert-success">
                <strong>Congratulations! Your server configuration satisfies all requirements.</strong>	
            </div>
        <?php endif; ?>

        <h3>Details
		<?php if(!file_exists($chkDbFile)) : ?>
		<?php $class = (($summary['errors'] > 0) ? "disabled" : ""); ?>
		<div class="pull-right"><a title="Install link" href="install.php" class="btn btn-primary <?php echo $class;?>" title="Install Button">Click here to install </a></div>
		<?php endif; ?>
	</h3>	
        <table class="table table-bordered">
            <tr><th>Name</th><th>Result</th><th>Required By</th><th>Memo/Details</th></tr>
            <?php foreach ($requiredData as $requirement): ?>	
            <tr class="<?php echo $requirement['condition'] ? 'success' : ($requirement['mandatory'] ? 'danger' : 'warning') ?>">
                <td>
                <?php echo $requirement['name'] ?>
                </td>
                <td>
                <span class="result"><?php echo $requirement['condition'] ? 'Passed' : ($requirement['mandatory'] ? 'Failed' : 'Warning') ?></span>
                </td>
                <td>
                <?php echo $requirement['by'] ?>
                </td>
                <td>
                <?php echo $requirement['memo'] ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

    </div>

    <hr>

    <div class="footer">
        <p>Server: <?php echo $requirementsChecker->getServerInfo() . ' ' . $requirementsChecker->getNowDate() ?></p>
        <p>Powered by <a href="http://www.yiiframework.com/" rel="external">Yii Framework</a></p>
    </div>
</div>
</body>
</html>