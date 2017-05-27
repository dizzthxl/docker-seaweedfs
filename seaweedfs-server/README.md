# FastDFS Docker

Usage:(最后一个参数为说明)

#http://studygolang.com/articles/2399
#master(defaultReplication复制模式为 "001" ， 也就是在相同 Rack 下复制副本为一份)
docker run -itd -p 9333:9333 --name seaweedfs-master ubuntu-seaweedfs master -defaultReplication=001 -ip="192.168.126.245" -port=9333


docker run -itd -p 9333:9333 --name seaweedfs-master ubuntu-seaweedfs master -ip="192.168.126.245" -port=9333


#volume(需要挂载目录到宿主机)
docker run -itd -p 9080:9080 --name seaweedfs-volume -v /var/seaweedfs/data:/var/seaweedfs/data ubuntu-seaweedfs volume -dir="/var/seaweedfs/data" -max=5 -mserver="192.168.126.245:9333" -ip="192.168.126.245" -port=9080

docker run -itd -p 9080:9080 --name seaweedfs-volume -v /var/seaweedfs/data:/var/seaweedfs/data ubuntu-seaweedfs volume -dir="/var/seaweedfs/data" -mserver="192.168.126.245:9333" -ip="192.168.126.245" -port=9080

#测试上传下载
1）获取Fid和URL
curl -X POST http://localhost:9333/dir/assign
{"fid":"1,0240cd0175","url":"172.18.0.3:8080","publicUrl":"172.18.0.3:8080","count":1}

2）上传文件
curl -X PUT -F file=@/home/maqingxiong/tf/vue.png http://172.18.0.3:8080/1,0240cd0175
{"name":"vue.png","size":96908}

3)浏览文件
http://宿主机ip:8080/1,0240cd0175
