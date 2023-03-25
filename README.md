UnrealIRCd RPC
==============

This allows PHP scripts to control [UnrealIRCd](https://www.unrealircd.org/)
via the [JSON-RPC interface](https://www.unrealircd.org/docs/JSON-RPC).

This is used by the
[UnrealIRCd webpanel](https://github.com/unrealircd/unrealircd-webpanel/)

If you are interested in helping out or would like to discuss API
capabilities, join us at `#unreal-webpanel` at irc.unrealircd.org
(IRC with TLS on port 6697).

Installation
------------
```bash
composer require unrealircd/unrealircd-rpc:dev-main
```

UnrealIRCd setup
-----------------
UnrealIRCd 6.0.6 or later is needed and you need to configure it as explained
in [JSON-RPC on the wiki](https://www.unrealircd.org/docs/JSON-RPC).
After doing that, be sure to rehash the IRCd.

Usage
-----
For this example, create a file like `src/rpctest.php` with:
```php
<?php
    require dirname(__DIR__) . '/vendor/autoload.php';

    use UnrealIRCd\Connection;

    $api_login = 'api:apiPASSWORD'; // same as in the rpc-user block in UnrealIRCd

    $rpc = new UnrealIRCd\Connection("wss://127.0.0.1:8600/",
                        $api_login,
                        Array("tls_verify"=>FALSE));

    $bans = $rpc->serverban()->getAll();
    foreach ($bans as $ban)
        echo "There's a $ban->type on $ban->name\n";

    $users = $rpc->user()->getAll();
    foreach ($users as $user)
        echo "User $user->name\n";

    $channels = $rpc->channel()->getAll();
    foreach ($channels as $channel)
        echo "Channel $channel->name ($channel->num_users user[s])\n";
```
Then, run it on the command line with `php src/rpctest.php`

If the example does not work, then make sure you have configured your
UnrealIRCd correctly, with the same API username and password you use
here, with an allowed IP, and changing the `wss://127.0.0.1:8600/` too
if needed.
