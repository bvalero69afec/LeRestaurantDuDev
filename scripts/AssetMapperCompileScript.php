<?php

if (getenv('SCRIPT_ASSET_MAPPER_COMPILE') === '1') {
    $c = 1;
    passthru('php bin/console asset-map:compile', $c);
    exit($c);
}
