# JAMMU #

JAMMU est une application qui vous permet de créer facilement vos applications SMS. En plus de son usage qui est simple, JAMMU est facile à configurer comme vous le découvrirez.

## Prérequis ##

Pour utilisez JAMMU vous devriez avoir installer ```php``` et ```apache```.

## Installation ##

Pour installer JAMMU clonez le dépot officiel.
Ensuite rendez vous dans le dossiez ou se trouve JAMMU. Dans ce dossier vous trouverez le contenu de l'application.

JAMMU se constitue d'une application PHP et d'une application mobile Android.

### Pour l'application mobile ###

Installez l'application mobile `jammu-app.apk` et accordez lui les permissions requises.
Connectez votre téléphone au wifi sur le même réseau que votre ordinateur.
Ensuite ouvrez l'application et dans la barre de recherche entrez l'adresse de votre ordinateur sur le réseau.

Par exemple: `http://192.168.1.111/JAMMU/`. Puis appuyez sur le bouton `Start server`.
Si après le `loading` le server demarre et reste sur la vue `serving` pendans plus de 5s, alors la connexion est réussie.

**NB: N'oubliez pas le `/` à la fin de l'adresse.**

### Pour le reste ###

Le dossier de JAMMU doit se trouvez soit dans votre `localhost` dans quel cas pour y acceder il faudra par exemple `http://192.168.1.111/JAMMU/`.
Dans le second cas vous pouvez lancer le serveur apache directement depuis le dossier d'installation de JAMMU si vous ne désirez pas le mettre dans le `localhost`.

Avec votre terminal placez vous dans le dossier de JAMMU et executez la commande suivante:

```cmd
./jammu-watch votre_adresse_sur_le_reseau:port_choisis
```

Ex: Si votre l'adresse IP de votre machine est 192.168.1.15, placez vous dans le dossier de votre application JAMMU et faites:

```cmd
./jammu-watch 192.168.1.15:9000
```

***9000 étant le port choisi.***

Ensuite dans l'application mobile mettez dans la barre de recherche: `http://192.168.1.15:9000/`

## Comment utiliser JAMMU ##

Parmis les fichiers installés, celui dans lequel vous serrez appelés à developper votre application est le fichier `jammu-conf`.
Ce fichier contient une Classe nommée `Jammu` et fait appel à la classe `JammuI`.

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

Et pour envoyer un message groupé ...

```php
<?php
	JammuI::sendMessage([
		"address" => ["+22503552233", "+22509876543", "+22567568798"],
		"body" => "Hello World !"
	]);

	// ou encore

	JammuI::sendMessage([
		"address" => "+22503552233, +22509876543, +22567568798",
		"body" => "Hello World !"
	]);
```

### Depuis la ligne de commande ###

Avec votre terminal, placez vous dans le dossier ou vous avez installé JAMMU. puis executez la commande qui suit:

```cmd
./jammu-send "+22501020304" "Hello World !"
```

Et pour envoyer un message groupé ...

```cmd
./jammu-send "+22503552233, +22509876543, +22567568798" "Hello World !"
```

Si vous avez une liste de contact dans un fichier formaté comme suit:

```cmd
01020304
03020476
01989786
07867653
```

Faites:

```cmd
./jammu-send "path:chemin/vers/le/fichier" "Contenu du message"
```

## jammu-watch ##

Si vous avez besoin de faire une application qui execute des commande de la console, alors il vous faudra imperativement passer par **jammu-watch**.
Avec le terminal placez vous dans le dossier ou vous avez installé JAMMU et executez la commande:

```cmd
./jammu-watch votre_adresse_sur_le_reseau:port_choisis
```

Et c'est tout pour l'activation (Pour l'arreter faites **Ctrl + C** dans le terminal.)
Une fois cela fait, dans votre application vous pouvez executer la commande que vous souhaitez en faisant comme suit:

```php
<?php
	JammuI::exec("notify-send \"Hello World\" ");
```

**IMPORTANT:** Pour jammu-watch, après chaque modification du code, il vous faudra redemarer le watcher en faisant **Ctrl+C** puis **./jammu-watch**.