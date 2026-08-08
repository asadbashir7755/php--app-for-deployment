# PHP ELMS Deployment Target

A PHP and MySQL employee leave management system. It is here not as a web
development project but as the app my Ansible automation deploys. It is a
deliberately ordinary LAMP app to automate against.

Deployed by
[ansible-learning](https://github.com/asadbashir7755/ansible-learning), in
`07-project-php-lamp-deployment/`.

Portfolio: [committodeploy.dev](https://committodeploy.dev)

## Why this app

Automation is only interesting if the thing being automated is realistic. This one
has the parts that make a deployment awkward:

- A database that has to be created, seeded and granted before the app will start
- Apache virtual host and document root config
- A service user with a nologin shell
- File permissions that matter, since `assets/` has to be writable and config must
  not be
- Different database credentials per environment, which is what drives the staging
  and production vault split on the Ansible side

## Layout

```
index.php                 login and entry point
dashboard.php             employee dashboard
apply-leave.php           leave request form
leave-details.php         request detail view
leavehistory.php          history
myprofile.php             profile management
emp-changepassword.php    password change
forgot-password.php       recovery
chatwith-admin.php        employee and admin messaging
admin/                    admin panel
includes/                 shared config, header, footer, db connection
assets/                   CSS, JS, images, vendor libraries
elmsdb.sql                schema and seed data
```

## Manual setup

The whole point of the Ansible project is that you should not have to do this by
hand, but for reference:

```bash
# database
mysql -u root -p -e "CREATE DATABASE elmsdb;"
mysql -u root -p elmsdb < elmsdb.sql

# app user
mysql -u root -p -e "CREATE USER 'elms_user'@'localhost' IDENTIFIED BY '<password>';"
mysql -u root -p -e "GRANT ALL ON elmsdb.* TO 'elms_user'@'localhost'; FLUSH PRIVILEGES;"

# then point includes/config.php at your database
# and serve the folder with Apache and mod_php
```

## Automated setup

```bash
git clone git@github.com:asadbashir7755/ansible-learning.git
cd ansible-learning/07-project-php-lamp-deployment

ansible-playbook playbooks/lampstack.yaml \
  -i inventory/dev \
  -e @vault_1.1_prod/vault.yaml \
  --ask-vault-pass
```

## Notes

This is a third party training app, not code I wrote. It is here as something to
deploy. Treat the PHP itself as legacy tutorial code.

`elmsdb.sql` has demo seed data only. The sample employee records and the admin
account, which is an unsalted MD5 hash, are fixtures from the original training
app. They are not real people and not real credentials. Do not put this on the
internet as it is.

Database credentials come from Ansible Vault at deploy time. Nothing real is
committed here.

## Tech stack

PHP, MySQL, Apache, HTML, CSS, JavaScript
