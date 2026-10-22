# Exponential Class Lists (ezclasslists)

Exponential Class Lists adds a **Lists by class** tab to the Exponential administration interface. The tab lists
every content object of one content class, wherever it lives in the content tree, so an editor or administrator can
find, open, edit or remove all the articles, folders, images or users of a site from one page.

It is meant for site administrators and editors who need an overview of "all objects of class X": cleaning up
test content, checking what was published recently, or finding objects that are hard to reach through the tree.

## Features

- A **Lists by class** tab in the admin header (admin4 draws the `list-ul` icon before its name).
- A class selector in the left menu. All content classes are offered, or only the ones listed in `lists.ini`.
- Sorting by depth, name, path, path string, priority, modified date, published date or section, ascending or
  descending.
- 10, 25 or 50 items per page, remembered per user (the `admin_classlists_limit` user preference).
- For each object: its name (linked to the object), its class (linked to that class's list), its modification
  date and an edit button.
- Removal of several objects at once, optionally moving them to the trash, with an optional confirmation dialog.
- In the admin's class view, the **Object count** links to the list of that class's objects.
- In the class context menu, a **View objects of this class** entry.

Only main locations are listed (`main_node_only`), so an object with several locations appears once.

## Requirements

- Exponential 6.x (the legacy kernel)
- PHP 8.0 or later
- No other extension is needed.

## Installation

### With Composer

The package is installed from its GitHub repository:

```bash
composer config repositories.ezclasslists vcs https://github.com/se7enxweb/ezclasslists
composer require se7enxweb/ezclasslists:^1.3
```

The `se7enxweb/ezpublish-legacy-installer` plugin puts it into `extension/ezclasslists`.

### By hand

1. Download the release archive from https://github.com/se7enxweb/ezclasslists/releases and unpack it, or clone the
   repository:

   ```bash
   cd /path/to/exponential
   git clone https://github.com/se7enxweb/ezclasslists.git extension/ezclasslists
   ```

   The directory must be called `extension/ezclasslists`.

### Activate it

Add the extension to `settings/override/site.ini.append.php`:

```ini
[ExtensionSettings]
ActiveExtensions[]=ezclasslists
```

Then regenerate the autoloads and clear the caches, from the installation's root directory:

```bash
php bin/php/ezpgenerateautoloads.php -e
php bin/php/ezcache.php --clear-all
```

Log out of the admin and back in (or clear the INI cache) and the **Lists by class** tab appears.

## Configuration

The extension reads `lists.ini`. Copy the settings you want to change into
`settings/override/lists.ini.append.php` (or a siteaccess's `lists.ini.append.php`); do not edit the file inside
the extension.

```ini
<?php /*

[DeleteSettings]
# enabled: ask "Are you sure you want to delete these objects ?" before removing
ConfirmJavascript=enabled
# enabled: the "Move to trash" box is checked by default
DefaultMoveToTrash=enabled

[ListSettings]
# depth, modified, name, path, path_string, priority, published or section
DefaultSortMethod=modified
# ascending or descending
DefaultSortOrder=descending

# Empty: every content class is offered in the left menu.
# Otherwise only the classes listed here, by identifier:
IncludeClasses[]
IncludeClasses[]=article
IncludeClasses[]=folder
IncludeClasses[]=image

*/ ?>
```

The extension also sets these, which normally need no change:

| File | Setting | Purpose |
| --- | --- | --- |
| `menu.ini` | `[TopAdminMenu] Tabs[]=classlists`, `[Topmenu_classlists]` | the admin tab, its icon (`Icon=list-ul`) and its URL |
| `module.ini` | `ModuleList[]=classlists` | registers the `classlists` module |
| `design.ini` | `DesignExtensions[]=ezclasslists` | makes the templates available |
| `site.ini` | `TranslationExtensions[]=ezclasslists` | loads the French translation |

To hide the tab without disabling the module, remove it from the tab list in
`settings/override/menu.ini.append.php`:

```ini
[TopAdminMenu]
Tabs[]
Tabs[]=content
Tabs[]=media
# ... the tabs you want, without classlists
```

## Usage

1. Open the administration interface and click the **Lists by class** tab. It opens the list of folders
   (`classlists/list/folder`).
2. In the left menu, choose a class in **Classes list**, a **Sort by** field and a **Sort order**, and press **Go**.
3. Click an object's name to open it, its class to list that class, or the pencil to edit it.
4. To remove objects, check them (the header icon inverts the selection), choose whether to move them to the trash,
   and press **Remove selected**. Objects the current user may not remove have a disabled check box.

The view can also be opened by URL, which makes bookmarks easy:

```
classlists/list/<class identifier or id>/<sort method>/<sort order>
classlists/list/article/published/descending
classlists/list/16/name/ascending/(offset)/50
```

A link to it from your own admin templates:

```
<a href={concat( 'classlists/list/', $class.identifier )|ezurl()}>{$class.object_count}</a>
```

The list itself is built with the standard content fetches, so the same result can be had in any template:

```
{def $articles = fetch( 'content', 'tree', hash( 'parent_node_id', 1,
                                                 'class_filter_type', 'include',
                                                 'class_filter_array', array( 'article' ),
                                                 'main_node_only', true(),
                                                 'sort_by', array( 'published', false() ),
                                                 'limit', 10 ) )}
```

## Permissions

The module has one function, `classlists/read`, needed to see the tab and the list. Give it to a role in
**Users > Roles**: add a policy with module `classlists`, function `read`. Administrators (all modules) have it
already.

Viewing, editing and removing objects from the list use the normal content permissions: the list only shows what the
user may read, and removal is offered only where the user may remove.

## Cron jobs and scripts

None.

## Upgrading

From 1.2 or earlier: replace the extension's directory with the new release, regenerate the autoloads and clear the
caches (see Installation). Since 1.3 the left menu's **Go** button reloads the page instead of loading the list
through YUI 2; nothing needs to be configured for it. If your own `design.ini` override added
`BackendJavaScriptList[]=classlists.js`, remove that line: the file is gone.

## Known limits

- The list starts at the top of the content tree (node 1), so it includes the users and the media library.
- The extension ships copies of admin templates from its original 2011 release: `design/admin/templates/class/view.tpl`
  and `design/admin/templates/popupmenu/popup_menu.tpl` (and, for older installations, the `design/admin2` ones). They
  replace the kernel's admin templates of the same name, so a change the kernel made later to the class view or the
  context menus is not seen while the extension is active. If that matters to you, remove those overrides from your
  copy; the tab and the list work without them.
- The templates use the classic admin markup (`box-header`, `context-block`); they render in every admin design but
  do not use admin4's own components.
- Translations: French only.

## Troubleshooting

- **The tab does not appear**: check that `ActiveExtensions[]=ezclasslists` is set, clear the INI cache
  (`php bin/php/ezcache.php --clear-tag=ini`) and log in again. Users without `classlists/read` do not see it.
- **"Module not found" for classlists/list**: regenerate the autoloads and clear the caches.
- **"... is not a valid content class identifier."**: the class identifier in the URL does not exist. Use the
  identifier shown in **Setup > Classes**.
- **A class is missing from the left menu**: `IncludeClasses[]` in `lists.ini` limits the list; empty it to offer all
  classes.

## Contributing

Issues and pull requests are welcome at https://github.com/se7enxweb/ezclasslists.

## License

GNU General Public License v2.0, see the `GPL` file.

## Credits and history

Damien Pobel wrote eZ Class Lists in 2007 for eZ Publish, the content management system that Exponential continues,
and published it on projects.ez.no, where release 1.2 was the last (2011). 7x maintains it for Exponential since
2026: release 1.3 added the admin tab's icon, dropped the YUI 2 dependency and modernized the package files and
this guide.
