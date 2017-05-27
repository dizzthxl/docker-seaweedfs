FROM ubuntu

LABEL maintainer "plokplokplok@163.com"

# go语言安装
RUN apt-get update
RUN apt-get install -y software-properties-common
RUN apt-get install -y python-software-properties
#RUN add-apt-repository -y ppa:gophers/go
#RUN apt-get update
RUN apt-get install -y golang-go git-core mercurial

RUN mkdir -p /usr/webserver/go/seaweedfs
RUN mkdir -p /usr/webserver/go/bin
RUN mkdir -p /usr/local/go/bin
#数据目录
RUN mkdir -p /var/seaweedfs/data

#环境变量
COPY profile_plug /tmp/profile_plug
RUN cat /tmp/profile_plug >> /etc/profile

#weed项目
COPY weed /usr/webserver/go/seaweedfs/weed
RUN chmod 777 /usr/webserver/go/seaweedfs/weed

WORKDIR /usr/webserver/go/

COPY start.sh /usr/bin/start.sh

#make the start.sh executable 
RUN chmod 777 /usr/bin/start.sh

#如不需要nginx，可去掉第二个参数
ENTRYPOINT ["/usr/bin/start.sh"]
