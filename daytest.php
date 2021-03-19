<?php
echo date('Y-m-d', strtotime("+7 day"));
echo urlencode('KL-1-99-' . uniqid());
echo date('Y-m-d', strtotime('2021-01-01 + 28 day'));
?>