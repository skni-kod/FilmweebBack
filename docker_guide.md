# Docker installation guide and project setup

## Installation of docker on Bindows 10 machine

Go to `Control Panel\Programs\Programs and Features` and click `Turn Windows Features on or off` and mark `Hyper-V`.  

![Hyper-V](https://i.imgur.com/cmvp5zz.png)
Next open PowerShell as administrator and type `wsl --install`  
![Imgur](https://i.imgur.com/pnBVWEa.png)  
Reboot your machine.  

Afrer rebooting, if everything went good you should see this cmd window:
![ubuntu](https://i.imgur.com/r5qz4aI.png)

After few minutes a configuration prompt will apear. Enter your username and password (they don't need to match your windows credentials)

![ubuntu](https://i.imgur.com/33du1hL.png)

Now, we can install docker by running this command:
```bash
curl -fsSL https://get.docker.com  | sudo bash
```

`curl` command downloads install script from web and prints it to standart output. The `|` character redirects previous command's output to program on the right side of this operator. In our case it's system shell with admin rights.  
 Docker normally requires root privilages to operate. For example, to create, start or delete container we need to use `sudo` before every command which requires typing our password.  
 To omit this, we need to add our user to `docker` group. Thanks to that we won't need sudo.  
 ```bash
 sudo usermod -aG docker $USER
 ```
 This command adds `docker` group to your account (`$USER` is shell variable, you don't need to type your account name here).  
 
 Adding group to user requires relogin. To do this we need to close our window with ubuntu and open it again. To make sure that we are in `docker` group we need to type  
 ```bash
 groups
 ```
 ![groups](https://i.imgur.com/Ie4DBO6.png)
 
 `docker` binary is a CLI frontend. All work is done by program called `dockerd`. It is a background process called daemon.  We need to start it every time our wsl machine reboots. (Normally you just need to type `sudo systemctl enable --now docker`, but WSL does not support systemd as init system so I don't know how to permamently enable this daemon. You can just use Fedora or Arch like a normal person instead of this shit ¯\\\_(ツ)_/¯)  
 
 To do this we need to type in our terminal:  
 ```bash
 sudo service docker start
 ```
 
 To check if everything was set up correctly we run in our terminal:  
 ```bash
 docker run hello-world
 ```
 ![check](https://i.imgur.com/sDJh2xg.png)
 
 If there were no errors, our docker is up and running.  
 ## Setting up project
 Now we need to set up our project. To do this we need to change our working directory to one we want to put our project.  
 WSL mount our drives in `/mnt` folder. Now we need to change our working directory with `cd` command. In my case I want to clone repo to `Documents` folder.  
 ```bash
 cd /mnt/c/Users/user/Documents
 ```
 Remember that this folder is on your physical drive.  
 
 Now we need to clone our repo by typing in terminal:  
 ```bash
 git clone https://github.com/skni-kod/FilmweebBack
 ```
 Next, we need to enter directory with our project  
 ```bash
 cd FilmweebBack
 ```
 Before installing Laravel we need to copy `.env.example` to `.env`.  
 
 **WARNING!** Without doing this step your app won't work, because this file contains important config, for example information about database connection! Also, if you have services running on port 80 you need to disable them.  
 Now we have to install Sail. This script automates creating containers and manages them for us.  
 ```bash
 docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
 ```
 After installing we need just to type:  
 ```bash
 ./vendor/bin/sail up
 ```
 Before accessing our site we need to know our wsl IPv4 adress. To do this we need to type  
 ```bash
 ip a
 ```
 We need to search for eth0. In my case this look like this:  
 ```
 6: eth0: <BROADCAST,MULTICAST,UP,LOWER_UP> mtu 1500 qdisc mq state UP group default qlen 1000
    link/ether 00:15:5d:81:43:b8 brd ff:ff:ff:ff:ff:ff
    inet 172.31.121.189/20 brd 172.31.127.255 scope global eth0
       valid_lft forever preferred_lft forever
    inet6 fe80::215:5dff:fe81:43b8/64 scope link
       valid_lft forever preferred_lft forever
 ```
 `172.31.121.189` is our address.
 If there were no errors our projet should be available at http://<ip_address_from_above>/  
 
 ![it_works](https://i.imgur.com/e4iPcn5.png)
 
 <sub><sup>Guide by Szymon Kmieć</sup></sub>
