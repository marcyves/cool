#TSS

Thesis Selection system

##To Do

- Adapt Cool to Tss
    - Account
    - Change labels
    
    
Admin functions
   - Manage the list of programs

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


##Done

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
    - drop table role
    - alter table users to remove roleId column
    - funcs.php