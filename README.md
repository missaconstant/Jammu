# JAMMU #

JAMMU est une revanche sur GAMMU-SMSD jugé trop compliqué dans sa configuration. C'est une application simple d'usage. JAMMU est très simple à configurer comme vous le découvrirez.

## Installation ##

Pour installer JAMMU clonez le dépot officiel.
Ensuite rendez vous dans le dossiez ou se trouve JAMMU. Dans ce dossier vous trouverez le contenu de l'application.

JAMMU se constitue d'une application PHP et d'une application mobile Android.

### Pour l'application mobile ###

Installez l'application mobile `jammu-app.apk` et accordez lui les permissions requises.

### Pour le reste ###

À ce niveau, plus grand chose à faire. En effet l'installation est terminée

## Comment utiliser JAMMU ##

Dans parmis les fichiers installés, celui dans lequel vous serrez appelés à developper votre application est le fichier `jammu-conf`.
Ce fichier contient une Classe nommée `Jammu` et fait appel à la classe JammuI.

La methode `onMessage`.

```php
<?php

	public function onMessage (stdClass $message)
	{
		# do something with the incoming message
		# message-> : address, body, date_sent, date, service_center

		JammuI::say("Message reçu du ".$message->address);
	}
```

C'est cette méthode qui est exécutée lorsque vous recevez un message. Le message est alors contenu dans la variable `StdClass $message` passée en paramètre.

Le code suivant enregistre le message reçu dans un fichier nommé `monmessage.txt`.
```php
<?php

	public function onMessage (StdClass $message)
	{
		// on recuppère le numero
		$numero = $message->address;
		// on recuppère le contenu du message
		$contenu = $message->body;
		// on combine tout
		$msg = $numero.' : '.$contenu;
		// puis on enregistre
		file_puts_content('monmessage.txt', $contenu);
	}
```

Pour acceder au numero du destinateur faite `$message->address` et pour acceder au contenu du message `$message->body`.

## Envoyer un message ##

Pour envoyer un message avec JAMMU, on dispose de deux possibilités.

### Depuis le code de votre application ###

```php
<?php
	JammuI::sendMessage(["address" => "+22501020304", "body" => "Hello World !"]);
```

### Depuis la ligne de commande ###

Avec votre terminal, placez vous dans le dossier ou vous avez installé JAMMU. puis executez la commande qui suit:

```cmd
./jammu-send "+22501020304" "Hello World"
```

## jammu-watch ##

Si vous avez besoin de faire une application qui execute des commande de la console, alors il vous faudra activer le watcher. j'ai nommé **jammu-watch**.
Pour l'activer rien de plus simple. Avec le terminal placez vous dans le dossier ou vous avez installé JAMMU et executez la commande:

```cmd
./jammu-watch
```

Et c'est tout pour l'activation. Pour l'arreter faites **Ctrl + C** dans le terminal.
Une fois cela fait, dans votre application vous pouvez executer la commande que vous souhaitez en faisant comme suit:

```php
<?php
	JammuI::exec("notify-send \"Hello World\" ");
```

**IMPORTANT:** Pour jammu-watch, après chaque modification du code, il vous faudra redemarer le watcher en faisant **Ctrl+C** puis **./jammu-watch**.