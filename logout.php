<?php

include 'backend/Global.php';

SecureSession::destroySession();

redirect('/');
