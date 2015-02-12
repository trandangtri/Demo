#!/bin/bash

# ProcessWire install script.
#
# Usage:
#
# chmod +x ./processwire.sh
# ./processwire.sh dev|master

# Variables
PW_REPO_URL="git://github.com/ryancramerdesign/ProcessWire.git"
FIXTURE_DIR=$(cd `dirname "${BASH_SOURCE[0]}"` && pwd)
INSTALL_PATH=$FIXTURE_DIR/processwire

# Output.
out ()
{
    echo "["`date +"%Y-%m-%d %T"`"] $1"
}

# Git checkout and install.
install ()
{
    echo ""
    out "ProcessWire installation script."
    echo ""
    out "Retrieving repository..."
    git clone -b $1 $2 $3
    out "Done!"
    echo ""

    sudo rm $INSTALL_PATH/install.php
    sudo mv $INSTALL_PATH/site-languages $INSTALL_PATH/site
    sudo cp $FIXTURE_DIR/installed.php $INSTALL_PATH/site/assets/installed.php
    sudo cp $FIXTURE_DIR/config.php $INSTALL_PATH/site/config.php

    echo "Setting up the virtual host..."
    sudo cp $FIXTURE_DIR/processwire.conf /etc/nginx/sites-available/processwire.ongr.dev.conf
    sudo ln -s /etc/nginx/sites-available/processwire.ongr.dev.conf /etc/nginx/sites-enabled/processwire.ongr.dev.conf
    sudo nginx -s reload

    echo ""
    out "Install complete..."
    echo ""
}

args=("$@")
BRANCH=${args[0]}

if [ -z $BRANCH ]; then
out "No branch specified. Please run with either 'master' or 'dev' parameter."
out "E.g. './processwire.sh master'"
exit 0
fi

# Start the setup.
# Checkout from Git repository.
install $BRANCH $PW_REPO_URL $INSTALL_PATH
