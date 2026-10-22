<?php /*
#
# $Id: menu.ini.append.php 14 2009-11-11 21:39:38Z dpobel $
# $HeadURL: http://svn.projects.ez.no/ezclasslists/tags/ezclasslists_1_2/ezclasslists/settings/menu.ini.append.php $
#

[NavigationPart]
Part[classlists]=Lists by class

[TopAdminMenu]
Tabs[]=classlists

[Topmenu_classlists]
# Icon - (optional) the name of an icon admin4 draws before the tab's name: a name of design.ini
#        [AdminDesignSettings] IconList[] (Bootstrap Icons); a name it does not know draws no icon.
Icon=list-ul
NavigationPartIdentifier=classlists
Name=Lists by class
Tooltip=List object by content class
URL[]
URL[default]=classlists/list/folder
Enabled[]
Enabled[default]=true
Enabled[browse]=false
Enabled[edit]=false
Shown[]
Shown[navigation]=true
Shown[default]=true
Shown[browse]=true

*/ ?>
