=========
ONGR Demo
=========
ONGR is a platform based on Symfony 2 framework which stands in front of your application and withstands high load of concurrent users.

It is a separate system from your original application where you re-implement or move view and frontend related code to ONGR for high-performance content delivery. Product and other data is still managed by original backend and then continuously synchronized with new platform for cache and display.

If you find some issues or great ideas how to improve the project, please create an issue in GitHub. Also everyone are more than welcome to contribute using pull requests. More information is in `contributing page <https://github.com/ongr-io/ongr-handbook/blob/master/source/handbook/contributing/contributing.rst>`_.

.. image:: https://travis-ci.org/ongr-io/ongr-sandbox.svg?branch=master
:target: https://travis-ci.org/ongr-io/ongr-sandbox

.. image:: https://scrutinizer-ci.com/g/ongr-io/ongr-sandbox/badges/quality-score.png?b=master
:target: https://scrutinizer-ci.com/g/ongr-io/ongr-sandbox/?branch=master

.. image:: https://scrutinizer-ci.com/g/ongr-io/ongr-sandbox/badges/coverage.png?b=master
:target: https://scrutinizer-ci.com/g/ongr-io/ongr-sandbox/?branch=master

.. image:: https://insight.sensiolabs.com/projects/c87c7d17-ae5e-41df-bded-e2de25ad4484/mini.png
:target: https://insight.sensiolabs.com/projects/c87c7d17-ae5e-41df-bded-e2de25ad4484

.. image:: https://poser.pugx.org/ongr/ongr-sandbox/downloads.svg
:target: https://packagist.org/packages/ongr/ongr-sandbox

.. image:: https://poser.pugx.org/ongr/ongr-sandbox/v/stable.svg
:target: https://packagist.org/packages/ongr/ongr-sandbox

.. image:: https://poser.pugx.org/ongr/ongr-sandbox/v/unstable.svg
:target: https://packagist.org/packages/ongr/ongr-sandbox

.. image:: https://poser.pugx.org/ongr/ongr-sandbox/license.svg
:target: https://packagist.org/packages/ongr/ongr-sandbox


===========
Quick start
===========

Let's get started. We'll guide you step by step through installing and running ONGR the first time. The first installation should not need more than 1 hour.

Step 1: Requirements.
---------------------

Yes there are a few.

Please check if your development environment in our handbook.

Step 2: Download ONGR
---------------------

Download the latest release here `archive <https://github.com/ongr-io/ongr-sandbox/releases>`_ and unpack it somewhere under your project directory. Make sure that we have the "Vagrantfile" in the your project root folder.

Step 3: Install Virtual Box
---------------------------

Either install or upgrade `virtualbox <https://www.virtualbox.org/wiki/Downloads>`_. We need VirtualBox > 4.3

Step 4: Install Vagrant
-----------------------

Either install or upgrade `vagrant <https://www.vagrantup.com/downloads.html>`_. We need Vagrant >= 1.6.5

(optional) Now we need to install the hosts updater vagrant plugin.

.. code-block:: bash

    vagrant plugin install vagrant-hostsupdater

..

   It will help to automatically update /etc/hosts file via adding your new ongr.dev host with correct IP.

And finally - ONLY_FOR_LINUX you need to install the nfs server:

.. code-block:: bash

    sudo apt-get install nfs-kernel-server

..

Step 5: Start virtual machine using Vagrant
-------------------------------------------

Let's rock. Move into your project root folder and execute:

.. code-block:: bash

    vagrant up

..

(In case you have also something like VMWare installed on your local machine, it is a good idea to give the provider when upping your box:

.. code-block:: bash

    vagrant up --provider=virtualbox

..

)

That's it. The ONGR is alive.

If you experience any problems (e.g. vagrant tends to change the rules with each update and we might lag a bit) please do not hesitate to @@TODO contact us. We'll help.

Now, let's feed the donkey with some data.

Step 6: Install the demo data
-----------------------------

In case to get demo content you need to make a following steps:

.. code-block:: bash

    vagrant ssh
    cd /var/www
    composer install --no-interaction

..

   If composer prompts input questions just press enter.


Then run magento install script (be patient it takes some time):

.. code-block:: bash

    cd store
    ./magento.sh

..


Now You must create new index for ElasticSearch:

.. code-block:: bash

    cd ..
    app/console es:index:create

..

And import demo content for `ongr.dev <http://ongr.dev>`_ pages:

.. code-block:: bash

    app/console es:index:import --raw src/ONGR/DemoBundle/Resources/data/contents.json

..

Now you need to import data from magento to Your newly baked ONGR shop:

.. code-block:: bash

    app/console ongr:import:full magento.product
    app/console ongr:import:full magento.category

..

Step 7: Open your browser
-------------------------

Navigate your browser to `http://ongr.dev <http://ongr.dev/>`_

Here You will find Your new shops front end.


If You would visit `http://magento.ongr.dev/ <http://magento.ongr.dev/>`_  You would find original Magento e-shop with demo data.

If You would like to check Magento administrators UI go to `http://magento.ongr.dev/admin <http://magento.ongr.dev/admin>`_

    Username: admin

    Password: admin123
