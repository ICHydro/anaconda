Vagrant.configure("2") do |config|
  config.vm.provider "virtualbox" do |v|
    v.memory = 2048
  end
  config.vm.box = "ubuntu/xenial64"
  config.vm.synced_folder "www", "/var/www/anaconda", owner: "vagrant", group: "www-data", mount_options: ["dmode=775,fmode=664"]
  config.vm.synced_folder "installation", "/installation", owner: "vagrant", group: "www-data", mount_options: ["dmode=775,fmode=664"]
  config.vm.provision :shell, path: "installation/deploy_on_clean_vm.sh"
  config.vm.network :forwarded_port, guest: 80, host: 4567
  config.vm.network :forwarded_port, guest: 5432, host: 5433
  config.vm.network "private_network", ip: "192.168.10.80"
  config.vm.post_up_message = "Done."
end