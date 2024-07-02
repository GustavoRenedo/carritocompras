<?php
/* claves de acceso */
define("PAYPAL_CLIENTID", "Af7cyj5ibUGEMrxwaz1fBoiAUyo5CYIFKHK2jnQBHyhH_xZaM2bEWoCYEasgu5knqS98b1Y60Ao4_E3L");
define("PAYPAL_SECRET", "EM9PGTZ1C4GHetR26NPkOdFquB1dwf3Ehi3fz4N9Z_9hc0kejFtlVFkLjBBbL0uELgS94ZU4uiVzkK-I");
define("PAYPAL_BASEURL", "https://www.paypal.com/sdk/js?client-id=" . PAYPAL_CLIENTID . "&currency=MXN");
/*
    En las llamadas a la API REST, incluya la URL del servicio API para el entorno:
    Sandbox: https://api-m.sandbox.paypal.com
    Live: https://api-m.paypal.com
 */
define("PAYPAL_APIURL", "https://api-m.sandbox.paypal.com/");
