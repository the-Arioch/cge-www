#!/bin/bash
set -eu

find /home/groups/v/vr/vrmlengine/htdocs -type f -exec chmod 'o-wx' '{}' ';'
find /home/groups/v/vr/vrmlengine/htdocs -mindepth 1 \
  -type d -exec chmod 'o-w' '{}' ';'