df -H
sudo apt-get autoremove --purge
sudo apt-get clean
sudo journalctl --vacuum-time=3d
