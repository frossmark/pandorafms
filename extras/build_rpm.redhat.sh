#!/bin/bash
CODEHOME=/usr/src/pandora_4_open/
CODEHOME_ENT=/usr/src/artica_code/pandora/branches/4.0/
RPMHOME=/root/rpmbuild

if [ ! -d $RPMHOME/RPMS ]; then
	mkdir -p $RPMHOME/RPMS || exit 1
fi

echo "Creating REDHAT RPM packages in $RPMHOME/RPMS"

# Console
rpmbuild -ba $CODEHOME/pandora_console/pandora_console.redhat.spec || exit 1

# Server
rpmbuild -ba $CODEHOME/pandora_server/pandora_server.redhat.spec || exit 1

# Unix agent
rpmbuild -ba $CODEHOME/pandora_agents/unix/pandora_agent.redhat.spec || exit 1

# Enterprise console
rpmbuild -ba $CODEHOME_ENT/pandora_console/enterprise/pandora_console_enterprise.spec || exit 1

# Enterprise server
rpmbuild -ba $CODEHOME_ENT/pandora_server/PandoraFMS-Enterprise/pandora_server_enterprise.spec || exit 1

exit 0

