Hello guys, a lot of people search on internet how to create graph players on your own server, and thats script isn't upload on some forum/website, so I decided create and published script. This script have anything else besides graph, first things first.

1) Graph
Generally: Graph takse number players from GameTracker.rs Api, but if you had your script for scans your server info, you can easy change graph with your info.

You can see correctness graph:
http://prntscr.com/42ktbj
http://prntscr.com/42ktgq

2) I made here one more function to see on Gao map where is your server hosted.

http://prntscr.com/42idsq

3) And you have here one more simple class to see image of map which is on server.

I will explain where you put your ip and how to call function for some of these things

1) IP of your server you write in includes.php file

$gtapi = new GTApi('176.57.128.40', '27056');

instead of 176.57.128.40 you write your server ip and instead of 27056 you write your port

2) If you wanna see your graph of players on server, you must in index.php add:

$gtapi->GTBigGraficonPlayer();

2) If you wanna see where is your server hosted you must in index.php add:

echo $gtapi->GetServerHostedMap();

3) If you wanna see image of map which is currently on server, you must in index.php add:

echo $gtapi->GetCurrentMapImage();
