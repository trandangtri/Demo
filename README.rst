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

Intro
-----

- `Quick start </src/ONGR/DemoBundle/Resources/doc/index.rst>`_
- `Contributing <https://github.com/ongr-io/ongr-handbook/blob/master/source/handbook/contributing/contributing.rst>`_


ONGR uses and provides full support for `Elasticsearch Bundle <https://github.com/ongr-io/ElasticsearchBundle>`_.



Magento integration setup
-------------------------

Firs You must setup sandbox in vagrant, but not import any data.

Then run magento install script:

.. code-block:: bash

    cd store
    ./magento.sh

..


    If you want or need, You can access Magento shop frontend using `http://magento.ongr.dev/ <http://magento.ongr.dev/>`_

    or Magento administrators UI -  `http://magento.ongr.dev/admin <http://magento.ongr.dev/admin>`_

    Username: admin

    Password: admin123


Now You must create new index for ElasticSearch:

.. code-block:: bash

    app/console es:index:create

..

And import demo content for `ongr.dev <http://ongr.dev>`_ pages:

.. code-block:: bash

    app/console es:index:import --raw src/ONGR/DemoMagentoBundle/Resources/data/data.json

..

Now you need to import data from magento:

.. code-block:: bash

    app/console ongr:import:full magento.product
    app/console ongr:import:full magento.category

..

Afterwards set up Sync. So changes made in `http://magento.ongr.dev/admin <http://magento.ongr.dev/admin>`_
will be synchronized with `ongr.dev <http://ongr.dev>`_ :

.. code-block:: bash

    app/console ongr:sync:storage:create --shop-id=0 mysql
    app/console ongr:sync:provide:parameter last_sync_date --set='2015-01-01 11:55:55'

..
