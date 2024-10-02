# remote-send

php actor model toolkit [phluxor-remote](https://github.com/ytake/phluxor-remote) example.  

remote actor system communication example.

## Composer

```bash
$ docker compose up -d 
$ docker compose exec node1 composer install
```

### node1

```bash
$ docker compose exec node1 php node1.php
```

example

```bash
[2024-09-12T10:20:05.381542+00:00] Phluxor.INFO: actor system started {"id":"672LaPa7iUjt5nuxxtHUeb"} []
[2024-09-12T10:20:05.391609+00:00] Phluxor.INFO: Started Activator [] []
[2024-09-12T10:20:05.395260+00:00] Phluxor.INFO: Started EndpointManager [] []
[2024-09-12T10:20:05.397406+00:00] Phluxor.INFO: Starting Phluxor remote server {"address":"node1:50052"} []
```

### node2

```bash
$ docker compose exec node2 php node2.php
```

example

```bash
[2024-09-12T10:22:00.629499+00:00] Phluxor.INFO: actor system started {"id":"sjxkMGdzsnBECgm5974HmK"} []
[2024-09-12T10:22:00.640914+00:00] Phluxor.INFO: Started Activator [] []
[2024-09-12T10:22:00.645342+00:00] Phluxor.INFO: Started EndpointManager [] []
[2024-09-12T10:22:00.647943+00:00] Phluxor.INFO: Starting Phluxor remote server {"address":"node2:50053"} []
[2024-09-12T10:22:00.653363+00:00] Phluxor.INFO: Started WebSocket.EndpointWriter. connecting {"address":"node1:50052"} []
[2024-09-12T10:22:00.655078+00:00] Phluxor.INFO: Started EndpointWatcher {"address":"node1:50052"} []
[2024-09-12T10:22:00.685907+00:00] Phluxor.INFO: WebSocket.EndpointWriter connected {"address":"node1:50052"} []
/var/app/node2.php:33:
string(55) "Hello world from remote node. this is hello, 1726136520"
/var/app/node2.php:44:
string(57) "Hello Phluxor from remote node. this is hello, 1726136522"
[2024-09-12T10:22:02.230792+00:00] Phluxor.INFO: Killed Phluxor server [] []
[2024-09-12T10:22:03.224089+00:00] Phluxor.INFO: WebSocket.EndpointWriter closing connection {"address":"node1:50052"} []
[2024-09-12T10:22:03.228512+00:00] Phluxor.INFO: deadletter {"message":{"Phluxor\\ActorSystem\\ProtoBuf\\Terminated":[]},"sender":"","pid":"EndpointSupervisor"} []
```
