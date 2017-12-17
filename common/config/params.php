<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'user.rememberMeDuration' => 3600 * 24 * 30,
    'cookieDomain' => '.example.com',
    'frontendHostInfo' => 'http://example.com',
    'backendHostInfo' => 'http://backend.example.com',

    //количество месяцев продленной гарнатии
    'extendedWarrantyTime' => 12,
    //количество месяцев стандартной гарантии
    'standardWarrantyTime' => 12,
    //в течении этого времени в месяцах можно регистрировать гарантию
    'minTimeInvoiceReg' => 3,
    //в течении этого времени в месяцах от продажи можно регистрировать акт ввода в эксплуатацию
    'maxTimeActReg' => 2,
];
