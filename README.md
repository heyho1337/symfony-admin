# This is a symfony easyadmin project. 
## Will be editing and formatting this soon
### Stack
```
symfony
easyadmin
turbo-ux
stimulus
tailwind
mysql
```
The UI will be fully updated to use tailwind, and stimulus for custom controller functions. 
For now I have merged the basic css with tailwind using scss and css cascade layers.
This way I can add talwind classes, modify the bacis css and add uniq css code if needed.
The 1st bigger customization was to show the filters on the index page instead of a modal.
2nd was to modify the select input elements for tailwind.
I also removed the sidebar and created a normal header menu.
for now, these files will need to be added to the easyadmin vendor folder:
https://mega.nz/file/RaBwzRSR#eQWJJTm2S5pF45Y9ZwI_DcGiS-PdLb8n_a5pnFWwr1c
### commands to get it up
```
symfony console server:start -d
./node_modules/.bin/encore dev --watch
npm run watch:css
```