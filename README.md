UnrealIRCd RPC
==============

This allows PHP scripts to control [UnrealIRCd](https://www.unrealircd.org/)
via the [JSON-RPC interface](https://www.unrealircd.org/docs/JSON-RPC).

Currently this is just a proof-of-concept:
* It allows you to connect only using websockets
* It has only 1 function (`query`) to send a JSON-RPC request and receive a response,
  which is low-level. You need to know *exactly* what method to call and with
  what parameters. So there is no `listUsers` or things like that.
* There is only limited error checking
* Etc...

This is just a proof-of-concept to get things going and to see if there
is interest in making it a more serious library. A serious library would
abstract everything and provide functions such as `listUsers`, `listServerBans`,
`addServerBan`, etc. That way the programmer using it would not need to
know anything about JSON-RPC at all.

If you are interested in helping out to achieve that, join us at
#unreal-webpanel at irc.unrealircd.org (IRC with TLS on port 6697).

See also [Looking for webdevs to make UnrealIRCd webpanel](https://forums.unrealircd.org/viewtopic.php?t=9195),
both the 1st and 2nd post there in particular.

Installation
------------
```bash
composer require unrealircd/unrealircd-rpc
```

Usage
-----
```php
<?php
    require dirname(__DIR__) . '/vendor/autoload.php';

    use UnrealIRCdRPC\Connection;

    $api_login = 'api:password';

    $rpc = new UnrealIRCdRPC\Connection("wss://127.0.0.1:8000/",
                        $api_login,
                        Array("tls_verify"=>FALSE));

    $bans = $rpc->query("server_ban.list");
    foreach ($bans->list as $ban)
        echo $ban->type . " at " . $ban->name . "\n";
```
