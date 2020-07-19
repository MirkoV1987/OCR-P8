# OCR-P8 - ToDoList<br/>
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/ecb9b0dff3b742a2bbee8fcdc6e0ea5d)](https://www.codacy.com/manual/MirkoV1987/OCR-P8?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=MirkoV1987/OCR-P8&amp;utm_campaign=Badge_Grade)</br>
Projet 8 de mon parcours de Développeur d'applications - PHP/SYMFONY chez OpenClassrooms. Amélioration d'une application existante de ToDo & Co. Utilisation de Symfony 3, de PHPUnit pour les tests unitaires, de Behat pour les tests fonctionnels et de Blackfire pour l'audit de performance.

<b>Environnement utilisé durant le développement</b>
<li>Symfony 3.1.10</li>
<li>PHPUnit</li>
<li>Behat</li>
<li>Blackfire</li>
<li>Composer 1.2.7</li>
<li>WampServer 3.1.9</li>
<li>Apache 2.4.39</li>
<li>PHP 7.2.18</li>
<li>PhpMyAdmin 4.8.5</li> 
<li>MySQL 5.7.26</li>
<br/>
<b>INSTALLATION</b>
</br>
<li>Clonez ou téléchargez le repository GitHub dans le dossier voulu :</li></br>
</br>

    git clone https://github.com/MirkoV1987/OCR-P8.git
</br>
<li>Chargez toutes les dépendances du projet avec Composer, en lançant la commande :</li>
</br>

    composer update
</br>
<b>INSTALLATION DE LA BASE DE DONNÉES</b>
<li>Configurez vos variables d'environnement tel que la connexion à la base de données dans le fichier parameters.yml.</li>
</br>

    parameters:
        database_host: HOST
        database_port: PORT
        database_name: DATABASE_NAME
        database_user: DATABASE_USER
        database_password: DATABASE_PASSWORD
</br>
<li>Créez la base de données avec la commande Doctrine :</li>
</br>

    bin/console doctrine:database:create
</br>
<li>La base de données a été créée. Générez les tables du database en lançant la commande :</li>
</br>

    bin/console doctrine:schema:update --force
</br>
<b>LANCER LES TESTS UNITAIRES AVEC PHPUnit</b>
<li>Les tests unitaires se trouvent dans le dossier tests/AppBundle</li>
<li>Les fichiers HTML indiquant le <em>code coverage</em> de l'application se trouvent dans le dossier tests/test-coverage</li>
<li>Pour lancer les tests unitaires, se positionnez-vous dans le répertoire racine du projet et lancez la commande :</li>
</br>

    vendor/bin/phpunit (le chemin peut changer en fonction de l'emplacement d'installation de PHPUnit)
</br>
<li>Pour générer/mettre à jour les fichiers HMTL avec le <em>code coverage</em> de l'application, lancez la commande :</li>
</br>

    vendor/bin/phpunit --coverage-html tests/test-coverage (le chemin peut changer en fonction de l'emplacement choisi pour les fichiers HTML)
</br>
<b>PARTICIPER AU PROJET</b>
<li>Participez à l'évolution de ce projet en suivant le guide ci-dessous :</li>
</br>
<li><a href="https://github.com/MirkoV1987/OCR-P8/blob/master/CONTRIBUTING.MD" target="_blank">CONTRIBUTION</a></li>
</br>
<li>Félicitations ! Vous pouvez vous servir de ce projet et/ou participer à son évolution !</li>

