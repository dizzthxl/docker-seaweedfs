#!/bin/bash

#启动weed
/opt/go/seaweedfs/weed $*

#master
#/opt/go/seaweedfs/weed master -ip=192.168.126.245

#集群master
#m1 192.168.126.255
#/opt/go/seaweedfs/weed master -defaultReplication=100 -ip=192.168.126.255 -port=9333 -peers=192.168.126.255:9333,192.168.126.245:9333 -mdir /opt/data/go/seaweedfs/m1
#m2 192.168.126.245
#/opt/go/seaweedfs/weed master -defaultReplication=100 -ip=192.168.126.245 -port=9333 -peers=192.168.126.255:9333,192.168.126.245:9333 -mdir /opt/data/go/seaweedfs/m2

#volume
#/opt/go/seaweedfs/weed volume -dir=/opt/data/go/seaweedfs/v1 -max=5 -mserver=192.168.126.245:9333 -ip=192.168.126.245 -port=9080 -dataCenter=your-volume-name
