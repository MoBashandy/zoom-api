                                                              Zoom API

1- First you have to create App on zoom Name of the app is OAuth 2.0
  follow that link to create your app:
  https://developers.zoom.us/docs/integrations/create/

2- you will see after it some data don't forget to add your api link it will be my api in your server 
  ![image](https://github.com/MoBashandy/zoom-api/assets/105816920/b3d3ab10-a1be-4c7e-a930-c6573b51554f)

3- Copy your redirect uri and in the line 6,22 put your redirct intead of REDIRECT-URI 

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

    





      
  
