# Changelog

## 1.3 (2026-10-21)

- Updated: the **Lists by class** admin tab shows an icon (`Icon=list-ul` in `[Topmenu_classlists]` of
  `settings/menu.ini.append.php`), drawn by the admin4 design before the tab's name.
- Removed: the YUI 2 dependency. The left menu's **Go** button now submits the form and reloads the list; the
  `ezjsc::yui2` and `classlists.js` entries of `BackendJavaScriptList[]`, `classlists.js` and `loader.gif` are gone.
  Current ezjscore releases no longer ship YUI, so the old script only raised errors.
- Updated: `composer.json` (package `se7enxweb/ezclasslists`, PHP 8.0 or later, support links), `ezinfo.php` and a
  new `extension.xml` state the release, the license and the website.
- Updated: `README.md` replaces `README` with a complete guide: installation with Composer and by hand,
  configuration, usage with examples, permissions, upgrading, known limits and troubleshooting.

## 1.2 (2011)

- Last release by Damien Pobel on projects.ez.no.
