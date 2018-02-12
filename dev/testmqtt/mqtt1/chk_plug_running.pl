#!/usr/bin/perl -w

use strict;
# require Mail::Send;
use Net::SMTP;
 
my $line;
# my $Fom_Email = "57160033\@go.buu.ac.th";

my $receive_current_Plug1_isRunning = 0;
my $receive_current_Plug2_isRunning = 0;
my $receive_current_Plug3_isRunning = 0;
my $receive_current_Plug4_isRunning = 0;
# my $plug1_isRunning = 0;

open (PS, "ps aux | grep python |") || die "Failed: $!\n";

DONE: while($line = <PS>) {
  print $line;
  if ($line =~ /receive_current_Plug1.py/) {
    # server is still running
    # print "process is still running\n\n";
    $receive_current_Plug1_isRunning = 1;
  } elsif ($line =~ /receive_current_Plug2.py/) {
    # server is still running
    # print "process is still running\n\n";
    $receive_current_Plug2_isRunning = 1;
  } elsif ($line =~ /receive_current_Plug3.py/) {
    # server is still running
    # print "process is still running\n\n";
    $receive_current_Plug3_isRunning = 1;
  } elsif ($line =~ /receive_current_Plug4.py/) {
    # server is still running
    # print "process is still running\n\n";
    $receive_current_Plug4_isRunning = 1;
  } 
  # elsif ($line =~ /plug1.py/) {
  #   # server is still running
  #   # print "process is still running\n\n";
  #   $plug1_isRunning = 1;
  # } 
}

close (PS);

if($receive_current_Plug1_isRunning == 0) {
  print "process receive_current_Plug1.py is not running\n";
  open(PS2, "python /var/www/smartplug/web/dev/testmqtt/mqtt1/receive_current_Plug1.py & |") || die "Failed2: $!\n";
  close(PS2);
  print "----- start receive_current_Plug1.py successfully -----\n\n";
}
if($receive_current_Plug2_isRunning == 0) {
  # print "process receive_current_Plug1.py is not running\n";
  open(PS2, "python /var/www/smartplug/web/dev/testmqtt/mqtt1/receive_current_Plug2.py & |") || die "Failed2: $!\n";
  close(PS2);
  # print "----- start receive_current_Plug1.py successfully -----\n\n";
}
if($receive_current_Plug3_isRunning == 0) {
  # print "process receive_current_Plug1.py is not running\n";
  open(PS2, "python /var/www/smartplug/web/dev/testmqtt/mqtt1/receive_current_Plug3.py & |") || die "Failed2: $!\n";
  close(PS2);
  # print "----- start receive_current_Plug1.py successfully -----\n\n";
}
if($receive_current_Plug4_isRunning == 0) {
  # print "process receive_current_Plug1.py is not running\n";
  open(PS2, "python /var/www/smartplug/web/dev/testmqtt/mqtt1/receive_current_Plug4.py & |") || die "Failed2: $!\n";
  close(PS2);
  # print "----- start receive_current_Plug1.py successfully -----\n\n";
}
# if($plug1_isRunning == 0) {
#   # print "process plug1 is not running\n";
#   open(PS2, "cd /var/www/smartplug/web/dev/testmqtt/mqtt1; python plug1.py 1 & |") || die "Failed2: $!\n";
#   close(PS2);
#   # print "----- start successfully -----\n\n";
# }
