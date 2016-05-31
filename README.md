# STEP-BY-STEP

## 环境

环境通过vagrant搭建在虚拟机上

### vagrant up 如果已经启动了服务器，跳过此节

    ```shell
        # -*- mode: ruby -*-
        # vi: set ft=ruby :

        # Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
        VAGRANTFILE_API_VERSION = "2"

        Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

            config.vm.define "Study", autostart: false do |study|
                study.vm.box = "ubuntu/trusty64"
                study.vm.network "private_network", ip: "192.168.17.13"
                study.vm.network "forwarded_port", guest: 80, host: 80
                study.vm.synced_folder "~/Study", "/home/vagrant/Study", create: true, owner: "vagrant", group: "vagrant"
            end

            # change timezone
            config.vm.provision "shell", inline: "cp -p /usr/share/zoneinfo/Asia/Shanghai /etc/localtime"

            # disable sync current folder
            config.vm.synced_folder ".", "/vagrant", disabled: true

            # share .ssh
            # You can check with 
            #   ssh-add -L
            # if it's not listed, add it with 
            #   ssh-add ~/.ssh/id_rsa
            config.ssh.forward_agent = true

            # remove apt cache
            config.vm.provision "shell", inline: "rm -rf /var/lib/apt/lists/*"
        end
    ```

### 在虚拟机上安装nginx

    #### 安装

    ```shell
        sudo apt-get install nginx
    ```

    #### 配置

### 在虚拟机上安装docker

    参照官方手册：https://docs.docker.com/engine/installation/linux/ubuntulinux/

### 下载php image: image比较大，慢慢下

    ```shell
        docker pull php:5.6-fpm
    ```

### 启动php docker

    ```shell
        docker run -d -p 9000:9000 --name myphp -v "$PWD/www":/var/www/src php:5.6-fpm
    ```
