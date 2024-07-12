#!/bin/sh
SCRIPT=$(readlink -f "$0")
SCRIPT_PATH=$(dirname "$SCRIPT")
ROOT_DIR=$SCRIPT_PATH"/../"
VENDOR_DIR=$SCRIPT_PATH"/../vendor/"

if [ -d "$VENDOR_DIR" ]; then
  exit 0
fi

echo "Initialization ..."

chmod a+x "$ROOT_DIR/yii"
chmod a+w "$ROOT_DIR/web/assets/" "$ROOT_DIR/runtime/"

composer install
sleep 3 # Wait for MySQL warm up
yes | "$ROOT_DIR/yii" migrate
