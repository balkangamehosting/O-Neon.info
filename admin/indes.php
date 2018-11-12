<?php
$con = ssh2_connect("151.80.199.244", 7056);
ssh2_auth_password($con,"root","busa123");
 
if(ssh2_sftp($con))
{
echo "connected to 192.168.8.35";
}
else
{
echo "not connected";
}
?>