                                                              Zoom API

1- First you have to create App on zoom Name of the app is OAuth 2.0
  follow that link to create your app:
  https://developers.zoom.us/docs/integrations/create/

2- you will see after it some data don't forget to add your api link it will be my api in your server 
  ![image](https://github.com/MoBashandy/zoom-api/assets/105816920/b3d3ab10-a1be-4c7e-a930-c6573b51554f)

3- Copy your redirect uri and in the line 6,22 put your redirct intead of REDIRECT-URI  that will be in our case mo.html see where you but it and but it as a link it must be in server because zoom will call it to open to you and this step can't skip 

      $redirectURL = 'REDIRECT-URI';

4- Copy your Client id and in the line 9,23 put your Client id intead of CLIENT-ID

      $clientID = 'CLIENT-ID';

5- Copy your Client Secret and in the line 24 put your Client Secret intead of CLIENT-SECRET

      $clientSecret = 'CLIENT-SECRET';
6- if you want to add your meeting name or app name instead of $_GET['topic'] put it in line 74

      'topic' => $_GET['topic'] ?? 'New Meeting', 
      // 'topic' => APP-NAME ?? 'New Meeting',

7- if you want to add when the meeting start put it instead of $_GET['date'] in line 76

      'start_time' => $_GET['date'] ?? date('Y-m-d\TH:i:s') . 'Z',
      //'start_time' => Meeting time ?? date('Y-m-d\TH:i:s') . 'Z',

8- you must add how many minutes in the meet instead of $_GET['duration']  or it will open to only half an hour in line 77

     'duration' => $_GET['duration'] ?? 30,
    //'duration' => 120 ?? 30,

NOTE:
    
    the last three steps you can skip it because the next steps

10- in file mo.html in line 15 edit action="mo.html" to the link you will put in your html file 

Now after open the link to the api it will ask you about your permission like that :

![image](https://github.com/MoBashandy/zoom-api/assets/105816920/963f1167-b0f7-4cea-9b69-e6f677ff51a7)

after clicking allow you will find a page like that and it the same page that you have to put on redirect url that i name it mo.html :

![image](https://github.com/MoBashandy/zoom-api/assets/105816920/ee354bbe-9066-4f31-a842-512af16d6352)

put your data where topic is the name of the meet and Duration is How many minutes will the meeting last? 
and click get meeting link and you will get meeting link printing in whe web 
if you want it to open directly then edit on  the code in index.php at the line 140 instead of echo($link)
make it:

          header('Location: ' . $link);


      
  
