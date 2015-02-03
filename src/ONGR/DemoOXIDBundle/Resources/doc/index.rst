Setting up OXID demo
====================

Step 1: Vagrant.
----------------

Follow this `guide <../../../DemoBundle/Resources/doc/index.rst>`_ for setting up vagrant.

Step 2: Install OXID shop.
--------------------------

Run following scripts from vagrant.

.. code-block:: bash

    composer install --no-interaction
    store/oxid.sh

..

Shop will be available at  `http://oxid.ongr.dev <http://oxid.ongr.dev/>`_

Step 3: Importing Data.
-----------------------

Run following command to import data to ES database.

.. code-block:: bash

    app/console es:index:create --manager=oxid
    app/console es:index:import --manager=oxid --raw src/ONGR/DemoBundle/Resources/data/contents.json
    app/console ongr:import:full oxid.content
    app/console ongr:import:full oxid.category
    app/console ongr:import:full oxid.product

..

That's it your shop is now ready to browse.

Step 4: Synchronizing changes.
------------------------------

Setting up synchronization:

.. code-block:: bash
    app/console es:index:create
    app/console ongr:sync:storage:create --shop-id=0 mysql
    app/console ongr:sync:provide:parameter last_sync_date --set=2015-01-01

..

Then to synchronize changes made after importing run provide and one or all synchronizations.

.. code-block:: bash

    app/console ongr:sync:provide oxid

    app/console ongr:sync:execute oxid.content
    app/console ongr:sync:execute oxid.category
    app/console ongr:sync:execute oxid.product
..
