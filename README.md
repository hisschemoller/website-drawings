# Website Drawings

Page built with Vue, TypeScript and PHP on hisschemoller.com to show my drawings.

http://www.hisschemoller.com/drawings

## Local development

Use MAMP, point virtual host *website-drawings.localdev* to *public/* in this project.

http://website-drawings.localdev/backend/api.php<br>
Just dump the whole drawings table.

http://website-drawings.localdev/backend/edit.php<br>
Edit a drawing, its coordinates.

http://website-drawings.localdev/backend/list.php<br>
List of all drawings with edit links.

### Edit table helper

http://website-drawings.localdev/backend/_helper_edit_table.php

This file shows a list of all entries in the hisschemoller_drawings database table where the
latitude and longitude are both 0. It also immediately sets them to default values.

When entering coordinates for new drawings using Openstreetmaps it's handy to only have to adjust
their position from a location that is already nearby.

### Import files helper

http://website-drawings.localdev/backend/_helper_import_files.php

This file searches for all png image files in folder ../images/drawings-640/.<br>
For each file, it gets the width and height of the file
'../images/drawings-640/[base-name]640.png'.<br>
The same for files '../images/drawings-1280/[base-name]1280.png'.<br>
Both should exist. The script enters names, sizes, description and date as a row in database table
*hisschemoller_drawings*.<br>
<br>
A list is shown below of all the files found and rows entered.<br>
<br>
After the drawings are entered into the database the image files are copied by hand to the
'../images/drawings/' folder so the other ones are empty for the next batch.

### Rename files helper

http://website-drawings.localdev/backend/_helper_rename_files.php

This file get all image files in a folder and renames them, where the old filename is expected to be
a date and location, like '2016-06-06_weesperstraat.png', which would be renamed to 'wouter-hisschemoller_-_2016-06-06_weesperstraat_-_[640|1280].png'

### Resize files helper

http://website-drawings.localdev/backend/_helper_resize_files.php

This file get all image files in a folder, resizes them to 1280 px width, renames them from
'filename.png' to 'filename_-_1280.png' and saves them to '../images/drawings-1280/'.


## Foto's bewerken

1. Alle foto's zoveel mogelijk in dezelfde positie en met dezelfde belichting gefotografeerd. Alle in
dezelfde folder opgeslagen.
2. Photoshop: File > Scripts > Load Files into Stack...
  * Use: Folder
  * Browse...
  * Foto's verschijnen als layers.
3. Opslaan als Large Document Format *psb* bestand. Photoshop stelt dit voor als het bestand te groot
blijkt te worden bij opslaan.
  * Openen kan minuten lang duren bij een bestand van 2,5 GB.

## Foto's van tekeningen maken

* In plastic verpakt de plaat museumglas en stuk wit karton met aanleghoek.
* Microfoon statief met daarop de camera met schroefdraad adapter stukje.
* Lijmklemmen, houten latjes.

![Aanleghoek](assets/img/tafel1.jpg 'Aanleghoek')

![Glasplaat](assets/img/tafel2.jpg 'Glasplaat')

![Camera](assets/img/tafel3.jpg 'Camera')