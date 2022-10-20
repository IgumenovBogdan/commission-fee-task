#!/bin/bash
set -e

rm /root/.ssh/known_hosts
ssh -o "StrictHostKeyChecking no" -fN -p 40031 -L5432:timescaledb-access-0.timescaledb-access:5432 root@n0.c0.hgcloud.net || true
kill $(lsof -t -i:5432) || true
ssh -o "StrictHostKeyChecking no" -fN -p 40031 -L5432:timescaledb-access-0.timescaledb-access:5432 root@n1.c0.hgcloud.net || true
kill $(lsof -t -i:5432) || true
ssh -o "StrictHostKeyChecking no" -fN -p 40031 -L5432:timescaledb-access-0.timescaledb-access:5432 root@n2.c0.hgcloud.net || true
