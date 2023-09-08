<?php

use yii\helpers\Html;

?>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <div class="site-index">
            <div class="body-content">
                <div class="row">
                    <div class="col-md-6">
                        <p><b>Execution Time: <?= $jsonResultByQuery['time'] ?> seconds</b></p>

                        <h3>Result By yii2 query:</h3>
                        <pre id="json-result">
<?= $json = yii\helpers\Json::encode($jsonResultByQuery, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); ?>
                        </pre>
                    </div>
                    <div class="col-md-6">
                        <p><b>Execution Time: <?= $jsonResultBySqlQuery['time'] ?> seconds</b></p>
                        <h3>Result By Sql query:</h3>
                        <pre id="json-result">
<?= $json = yii\helpers\Json::encode($jsonResultBySqlQuery, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); ?>
                        </pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>






