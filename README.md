# Track-Gmail 
## A *opensource* plugin for Gmail to track emails.

### How it works?
The plugin calls to an external server that runs a simple PHP API, that has 3 functions:
- Generate initial row in db and get ID.
- Track when image with a token is rendered.
- Update DB, and notify user (needs work.)

*The plugin requires an external web server for an API.*

### How to setup ? 
-Google:
first you need to create a new google script project on https://script.google.com
then copy the files from the `gs` folder to your project root, and make sure to modify the `appscript.json` and the script code `example.com` to match yours.

-Self-hosted: 
copy the `php` folder contents to your server, make sure to upload your own `signature.png` file.
make sure the www-data(or the user that runs PHP on your server has writing accsess to the folder).

###  TODO:
well this needs a lot of work to be useable.
here is some of my ideas and road map, some of them probably won't see daylight while I try to work on others.
and the whole thing needs a rewrite either way :) 
#### Script.Google
##### - Rewrite the GS code.
##### - Add an option to upload custom images.
##### - Add an option to add custom HTML to the signature.
##### - Get the message ID after it was sent.
##### - Update the DB with message ID, Title.
##### - Detect when user views image.
##### - Use diffrent images while in "compose" and after the send button is pressed.
##### - Add tag "read" to sent mail once it was viewed by the target.
##### - Add option for proxy.
##### - Add Oauth for the API and get rid of that "somewhatsecurelol" param.

#### PHP
##### - Create custom 'secret' paramater,  get rid of that "somewhatsecurelol" param. 
##### - Add option for user to use custom image.
##### - Alert user once updated.
##### - Add user view mode(no update DB + No alert.)
##### - add option for proxy.
##### - Add Oauth.
