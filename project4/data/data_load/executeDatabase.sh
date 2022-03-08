#! /bin/bash

__dir="$(cd "$(dirname "${BASH_SOURCE}")" && pwd)"
cd ${__dir}/SQL_scripts/; sh ../createDatabase.sh