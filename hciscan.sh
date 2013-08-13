#!/bin/bash

# Scans for nearby Bluetooth devices and displays the IDs
while :
do
  hcitool scan --flush
  sleep 60
done