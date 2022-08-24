<?php

include 'admin/Backend/Global.php';

SecureSession::destroySession();

redirect('index.php');
