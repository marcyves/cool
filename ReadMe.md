#TSS

Thesis Selection system

##To Do

- Allow a professor to participate into different programs (user_settings.php)    
    
Admin functions
   - Manage the list of programs
   - Manage the list of disciplines
   - Manage the list of departments
   - Link professor users to departments and programs

- Review what to keep from the following todo:

- ADMIN: Faire un écran paramètrage pour l'administrateur pour fixer: le montant de l'initialisation des comptes banquier, le montant du découvert maxi (etc.)
- Le nombre de groupes max est hard codé dans la liste des groupes de user settings
- mailing list
- permettre de chercher sur un nom d’utilisateur
- procédure d’installation/création des groupes en ligne
- identification du cours
- procédure de nettoyage à la fin du cours.
- pouvoir faire tourner plusieurs cours (plusieurs BDD à la Dokeos ou contenu dans la BDD ?)
- Inclure un wiki pour le support du cours.
- inclure un calendrier
- affichage de news par les animateurs
- Allow Multilingual
- aide en ligne
- messagerie interne

##BUGS
- Clean up strings in order to allow ' (apostrophe) in thesis proposition description.

##Done
- Adapt Cool to Tss
    - DROP account table
    - Change labels

- Change references to 'team' into 'program'
    - user_settings.php
    - index.php
    - account.php
    - functions.php
    - funcs.php
    - en.php
    - class.user.php
    - ALTER table users to rename teamId column into programId

- remove references to 'role'
    - DROP table role
    - ALTER users table to remove roleId column
    - funcs.php

- Thesis Proposition
    - Delete wok.php and transfer code for proposition management into account.php
    - Delete market.php
    - ALTER market table to remove prestation, market_id and price
    - DROP prestation table
